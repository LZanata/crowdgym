<?php
include '../conexao.php';
session_start();

// Ativar logs de erro (para depuração temporária)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se a sessão está ativa
if (!isset($_SESSION['Academia_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$academia_id = $_SESSION['Academia_id'];

// Consulta SQL para obter dados
$query = $conexao->prepare("
    SELECT DATE_FORMAT(data_hora, '%H:%i') AS hora, MAX(alunos_treinando) AS total
    FROM historico_fluxo
    WHERE Academia_id = ?
    GROUP BY HOUR(data_hora)
    ORDER BY data_hora ASC
");

$query->bind_param("i", $academia_id);
$query->execute();
$resultado = $query->get_result();

$labels = [];
$data = [];

while ($linha = $resultado->fetch_assoc()) {
    $labels[] = $linha['hora'];
    $data[] = $linha['total'];
}

// Garantir que a saída é JSON puro
header('Content-Type: application/json');

if (empty($labels) || empty($data)) {
    echo json_encode(['error' => 'Sem dados para mostrar']);
} else {
    echo json_encode(['labels' => $labels, 'data' => $data]);
}

exit;
