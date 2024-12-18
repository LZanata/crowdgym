<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexao.php';

// Recebendo o ID da academia
$academiaId = isset($_GET['academiaId']) ? intval($_GET['academiaId']) : 0;

if ($academiaId <= 0) {
    echo json_encode(['error' => 'ID da academia inválido.']);
    exit;
}

try {
    // Consulta SQL para contar alunos ativos e inativos, considerando a data de término real
    $query = "
    SELECT 
        SUM(CASE 
            WHEN (DATE_ADD(s.data_inicio, INTERVAL p.duracao MONTH) >= CURDATE() AND s.data_fim >= CURDATE()) THEN 1 
            ELSE 0 
            END) AS ativos,
        SUM(CASE 
            WHEN (DATE_ADD(s.data_inicio, INTERVAL p.duracao MONTH) < CURDATE() OR s.data_fim < CURDATE() OR s.data_fim IS NULL) THEN 1 
            ELSE 0 
            END) AS inativos
    FROM aluno a
    LEFT JOIN assinatura s ON a.id = s.Aluno_id
    LEFT JOIN planos p ON s.Planos_id = p.id
    WHERE p.Academia_id = ?
";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $academiaId);
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
