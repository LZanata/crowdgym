<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../conexao.php';

try {
    // Verificar se o parâmetro academiaId foi passado na URL
    if (!isset($_GET['academiaId']) || !is_numeric($_GET['academiaId'])) {
        throw new Exception('Parametro academiaId não fornecido ou inválido');
    }

    $academiaId = (int) $_GET['academiaId'];

    // Consulta para calcular a receita mensal
    $query = "
    SELECT 
        YEAR(a.data_inicio) AS ano,
        MONTH(a.data_inicio) AS mes,
        SUM(p.valor) AS receita_total
    FROM assinatura a
    JOIN planos p ON a.Planos_id = p.id
    WHERE p.Academia_id = ?
    GROUP BY ano, mes
    ORDER BY ano DESC, mes DESC
    ";

    // Preparar a consulta
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Erro na preparação da consulta: ' . $conn->error);
    }

    // Associar o parametro academiaId
    $stmt->bind_param("i", $academiaId);

    // Executar a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Inicializar o array de dados
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'mes' => $row['mes'],
            'receita_total' => floatval($row['receita_total']) // Converte o valor para float
        ];
    }

    // Retornar os dados em formato JSON
    echo json_encode($data);
} catch (Exception $e) {
    // Retornar mensagem de erro em formato JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>