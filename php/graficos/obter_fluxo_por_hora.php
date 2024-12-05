<?php
header('Content-Type: application/json');

require '../conexao.php';

$academiaId = $_GET['academia_id'] ?? null;
$dias = $_GET['dias'] ?? 30; // Intervalo padrão: últimos 30 dias

if (!$academiaId) {
    echo json_encode(['error' => 'ID da academia não fornecido.']);
    exit;
}

try {
    $query = "SELECT 
                  HOUR(data_entrada) AS hora, 
                  COUNT(*) / COUNT(DISTINCT DATE(data_entrada)) AS media_alunos
              FROM entrada_saida
              WHERE Academia_id = ? 
              AND data_entrada >= NOW() - INTERVAL ? DAY
              GROUP BY hora 
              ORDER BY hora";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $academiaId, $dias);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inicializando um array com todas as horas (0 a 23) e valores de média como 0
    $dados = array_fill(0, 24, ['hora' => 0, 'media_alunos' => 0]);

    // Preenchendo os dados a partir da consulta
    while ($row = $result->fetch_assoc()) {
        $hora = (int)$row['hora'];
        $media_alunos = (float)$row['media_alunos'];
        $dados[$hora] = ['hora' => $hora, 'media_alunos' => $media_alunos];
    }

    echo json_encode($dados);
} catch (Exception $e) {
    error_log($e->getMessage()); // Registra no log
    echo json_encode(['error' => 'Erro ao consultar o banco de dados.']);
    exit;
}
?>
