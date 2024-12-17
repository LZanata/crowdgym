<?php
header('Content-Type: application/json');
error_reporting(E_ALL); 
ini_set('display_errors', 1);

include '../conexao.php';

$intervalo = isset($_GET['intervalo']) ? intval($_GET['intervalo']) : 30;
$academiaId = isset($_GET['academiaId']) ? intval($_GET['academiaId']) : 0;

// Query corrigida
$query = "
    SELECT 
        SUM(CASE 
                WHEN data_fim >= NOW() THEN 1 
                ELSE 0 
            END) AS renovados,
        SUM(CASE 
                WHEN data_fim < NOW() 
                     AND data_fim >= DATE_SUB(NOW(), INTERVAL ? DAY) THEN 1 
                ELSE 0 
            END) AS expirados
    FROM assinatura
    WHERE Planos_id IN (
        SELECT id FROM planos WHERE Academia_id = ?
    )
";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(['error' => 'Erro na preparação da consulta: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ii", $intervalo, $academiaId);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    echo json_encode(['error' => 'Erro ao obter os dados: ' . $conn->error]);
    exit;
}

echo json_encode([
    'renovados' => $result['renovados'] ?? 0,
    'expirados' => $result['expirados'] ?? 0
]);
?>
