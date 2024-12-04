<?php
require_once '../conexao.php';
require_once '../cadastro_login/check_login_aluno.php';

$aluno_id = $_SESSION['aluno_id'];

// Consulta para buscar as horas treinadas por dia na semana atual
$query = $conn->prepare("
    SELECT 
        DAYOFWEEK(data_entrada) AS dia_semana,
        SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, data_entrada, data_saida))) AS horas_totais
    FROM entrada_saida
    WHERE Aluno_id = ? 
      AND YEARWEEK(data_entrada, 1) = YEARWEEK(CURDATE(), 1) 
      AND data_saida IS NOT NULL
    GROUP BY DAYOFWEEK(data_entrada)
");
$query->bind_param("i", $aluno_id);
$query->execute();
$resultado = $query->get_result();

$horasTreinadas = array_fill(1, 7, 0); // Inicializa com 0 para todos os dias da semana (domingo a sábado)
while ($linha = $resultado->fetch_assoc()) {
    $diaSemana = (int)$linha['dia_semana'];
    $horasTotais = round((strtotime($linha['horas_totais']) - strtotime('TODAY')) / 3600, 2); // Converter para horas
    $horasTreinadas[$diaSemana] = $horasTotais;
}

// Formata os dados para o gráfico (segunda a domingo)
$horasSemanal = [
    $horasTreinadas[2], // Segunda-feira
    $horasTreinadas[3], // Terça-feira
    $horasTreinadas[4], // Quarta-feira
    $horasTreinadas[5], // Quinta-feira
    $horasTreinadas[6], // Sexta-feira
    $horasTreinadas[7], // Sábado
    $horasTreinadas[1], // Domingo
];

header("Content-Type: application/json");
echo json_encode($horasSemanal);
?>
