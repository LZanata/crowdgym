<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexao.php';

// Recebendo o ID da academia e intervalo
$academiaId = isset($_GET['academiaId']) ? intval($_GET['academiaId']) : 0;
$intervalo = isset($_GET['intervalo']) ? intval($_GET['intervalo']) : 30; // Padrão: 30 dias

if ($academiaId <= 0) {
    echo json_encode(['error' => 'ID da academia inválido.']);
    exit;
}

try {
    // Consulta SQL com filtro de intervalo
    $query = "
        SELECT 
            p.nome AS plano_nome,
            p.tipo AS plano_tipo,
            COUNT(a.id) AS quantidade
        FROM planos p
        LEFT JOIN assinatura a 
            ON p.id = a.Planos_id 
            AND a.data_inicio >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        WHERE p.Academia_id = ?
        GROUP BY p.nome, p.tipo
        ORDER BY quantidade DESC
    ";

    // Preparando a consulta
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    // Vinculando parâmetros
    $stmt->bind_param("ii", $intervalo, $academiaId);
    $stmt->execute();

    // Obtendo o resultado da consulta
    $result = $stmt->get_result();

    // Verificando se há resultados
    if ($result->num_rows === 0) {
        echo json_encode(['message' => 'Nenhum dado encontrado para os parâmetros fornecidos.']);
        exit;
    }

    // Montando os dados para o JSON
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'plano_nome' => $row['plano_nome'],
            'plano_tipo' => $row['plano_tipo'],
            'quantidade' => $row['quantidade']
        ];
    }

    // Retornando os dados em JSON
    echo json_encode($data);
} catch (Exception $e) {
    // Retornando um erro em caso de exceção
    echo json_encode(['error' => $e->getMessage()]);
}
?>
