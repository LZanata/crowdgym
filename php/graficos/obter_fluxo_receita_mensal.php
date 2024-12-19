<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexao.php';

try {
    // Consulta para calcular a receita mensal
    $query = "
    SELECT 
        DATE_FORMAT(a.data_inicio, '%Y-%m') AS mes, 
        SUM(p.valor) AS receita_total
    FROM assinatura a
    JOIN planos p ON a.Planos_id = p.id
    WHERE a.data_inicio IS NOT NULL
    GROUP BY mes
    ORDER BY mes ASC
    ";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'mes' => $row['mes'],
            'receita_total' => floatval($row['receita_total'])
        ];
    }

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
