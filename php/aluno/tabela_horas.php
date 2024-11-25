<?php
include '../conexao.php';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Definir o intervalo da semana atual (de domingo a sábado)
$hoje = date('Y-m-d');
$domingo = date('Y-m-d', strtotime('last sunday', strtotime($hoje)));
$sabado = date('Y-m-d', strtotime('next saturday', strtotime($hoje)));

// Consulta SQL para calcular a diferença entre data_entrada e data_saida em horas
$sql = "SELECT DATE(data_entrada) AS dia, 
               SUM(TIMESTAMPDIFF(SECOND, data_entrada, data_saida) / 3600) AS total_horas
        FROM entrada_saida
        WHERE Aluno_cpf = :Aluno_cpf 
          AND data_entrada BETWEEN :domingo AND :sabado
        GROUP BY dia";

$stmt = $conn->prepare($sql);
$stmt->execute(['Aluno_cpf' => 1, 'domingo' => $domingo, 'sabado' => $sabado]);

$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os dados no formato JSON
echo json_encode($resultados);
?>