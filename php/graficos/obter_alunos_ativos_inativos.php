<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexao.php';

// Recebendo o intervalo de dias
$intervalo = isset($_GET['intervalo']) ? intval($_GET['intervalo']) : 30; // Padrão: 30 dias

try {
    // Consulta para contar alunos ativos e inativos, com filtro de intervalo
    $query = "
    SELECT 
        COUNT(CASE WHEN a.data_inicio >= DATE_SUB(CURDATE(), INTERVAL ? DAY) AND (a.data_fim IS NULL OR a.data_fim >= CURDATE()) THEN 1 END) AS ativos,
        COUNT(CASE WHEN (a.data_inicio < DATE_SUB(CURDATE(), INTERVAL ? DAY) OR (a.data_fim IS NOT NULL AND a.data_fim < CURDATE())) THEN 1 END) AS inativos
    FROM aluno al
    LEFT JOIN assinatura a ON al.id = a.Aluno_id
    WHERE a.data_inicio IS NOT NULL
    ";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    // Bind do intervalo duas vezes para ativos e inativos
    $stmt->bind_param("ii", $intervalo, $intervalo);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = $result->fetch_assoc();

    echo json_encode([
        'ativos' => $data['ativos'],
        'inativos' => $data['inativos']
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
