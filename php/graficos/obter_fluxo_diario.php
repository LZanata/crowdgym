<?php
header('Content-Type: application/json');
try {
    include '../conexao.php';

    $academia_id = intval($_GET['academia_id'] ?? 0);
    $intervalo = $_GET['intervalo'] ?? 'semana'; // Valor padrão 'semana'
    $intervaloDias = ($intervalo == 'mes') ? 30 : 7; // Definindo o intervalo em dias (7 dias para semana, 30 para mês)

    if (!$academia_id) {
        throw new Exception("Academia não informada.");
    }

    $query = $conn->prepare("
        SELECT 
            DATE(data_entrada) AS dia,
            COUNT(*) AS total_alunos
        FROM 
            entrada_saida
        WHERE 
            Academia_id = ? AND data_entrada >= NOW() - INTERVAL ? DAY
        GROUP BY 
            DATE(data_entrada)
        ORDER BY 
            dia;
    ");
    $query->bind_param("ii", $academia_id, $intervaloDias);
    $query->execute();

    $resultado = $query->get_result();
    $dados = ['labels' => [], 'values' => []];

    while ($row = $resultado->fetch_assoc()) {
        $dados['labels'][] = $row['dia'];
        $dados['values'][] = $row['total_alunos'];
    }

    echo json_encode($dados);
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
?>
