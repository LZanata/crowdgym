<?php
header('Content-Type: application/json');

require '../conexao.php';

$academiaId = $_GET['academia_id'] ?? null;

if (!$academiaId) {
    echo json_encode(['error' => 'ID da academia não fornecido.']);
    exit;
}

try {
    $query = "SELECT 
                  HOUR(data_entrada) AS hora, 
                  COUNT(*) / COUNT(DISTINCT DATE(data_entrada)) AS media_alunos
              FROM entradas_saidas 
              WHERE Academia_id = ? 
              GROUP BY hora 
              ORDER BY hora";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $academiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $dados = [];
    while ($row = $result->fetch_assoc()) {
        $dados[] = ['hora' => (int)$row['hora'], 'media_alunos' => (float)$row['media_alunos']];
    }

    echo json_encode($dados);
} catch (Exception $e) {
    error_log($e->getMessage()); // Registra no log
    echo json_encode(['error' => 'Erro ao consultar o banco de dados.']);
    exit;
}
?>
