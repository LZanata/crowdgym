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
    // Consulta SQL para calcular a receita mensal por plano
    $query = "
    SELECT 
        YEAR(a.data_inicio) AS ano,
        MONTH(a.data_inicio) AS mes,
        p.nome AS plano_nome,
        p.tipo AS plano_tipo,
        SUM(p.valor) AS receita  -- Usando a coluna 'valor' para calcular a receita
    FROM assinatura a
    JOIN planos p ON a.Planos_id = p.id
    WHERE p.Academia_id = ?
    GROUP BY ano, mes, plano_nome, plano_tipo
    ORDER BY ano DESC, mes DESC
";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    $stmt->bind_param("i", $academiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'ano' => $row['ano'],
            'mes' => $row['mes'],
            'plano_nome' => $row['plano_nome'],
            'plano_tipo' => $row['plano_tipo'],
            'receita' => $row['receita']
        ];
    }

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
