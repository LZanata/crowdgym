<?php
header('Content-Type: application/json');

require '../conexao.php';

$academiaId = $_GET['academia_id'] ?? null;

if (!$academiaId) {
    echo json_encode(['status' => 'error', 'message' => 'ID da academia não fornecido.']);
    exit;
}

try {
    $query = "SELECT 
                  HOUR(data_entrada) AS hora, 
                  COUNT(*) / COUNT(DISTINCT DATE(data_entrada)) AS media_alunos
              FROM entrada_saida  -- Corrigido o nome da tabela
              WHERE Academia_id = ? 
              GROUP BY hora 
              ORDER BY hora";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $academiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $labels = [];
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $labels[] = str_pad($row['hora'], 2, '0', STR_PAD_LEFT) . ':00'; // Converte para formato 00:00
        $data[] = (float)$row['media_alunos'];
    }

    echo json_encode([
        'status' => 'success',
        'labels' => $labels,
        'data' => $data,
    ]);
} catch (Exception $e) {
    error_log($e->getMessage()); // Registra no log
    echo json_encode(['status' => 'error', 'message' => 'Erro ao consultar o banco de dados.']);
    exit;
}
?>
