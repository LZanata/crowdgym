<?php
require_once '../conexao.php';
require_once '../cadastro_login/check_login_aluno.php';

$aluno_id = $_SESSION['Aluno_id'];

$query = $conn->prepare("
    SELECT DATE_FORMAT(data_entrada, '%a, %d de %b') AS ultimo_treino,
           TIME_FORMAT(data_entrada, '%H:%i') AS horario_entrada,
           TIME_FORMAT(data_saida, '%H:%i') AS horario_saida
    FROM entrada_saida
    WHERE Aluno_id = ?
    ORDER BY data_entrada DESC
    LIMIT 1
");
$query->bind_param("i", $aluno_id);
$query->execute();
$resultado = $query->get_result();
$dados = $resultado->fetch_assoc();

echo json_encode([
    'ultimo_treino' => $dados['ultimo_treino'] ?? null,
    'horario_entrada' => $dados['horario_entrada'] ?? null,
    'horario_saida' => $dados['horario_saida'] ?? null,
]);
?>
