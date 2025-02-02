<?php
header('Content-Type: application/json');
try {
    include '../conexao.php';

    $academia_id = intval($_GET['academia_id'] ?? 0);
    $dias = intval($_GET['intervalo'] ?? 7);

    if (!$academia_id || $dias <= 0) {
        throw new Exception("Parâmetros inválidos.");
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
    $query->bind_param("ii", $academia_id, $dias);
    $query->execute();

    $resultado = $query->get_result();
    $dados = ['labels' => [], 'values' => []];

    while ($row = $resultado->fetch_assoc()) {
        $dados['labels'][] = $row['dia'];
        $dados['values'][] = $row['total_alunos'];
    }

    // Verifique se temos dados suficientes
    if (empty($dados['labels']) || empty($dados['values'])) {
        echo json_encode(['erro' => 'Não há dados suficientes para gerar o gráfico.']);
    } else {
        echo json_encode($dados);
    }
} catch (Exception $e) {
    echo json_encode(['erro' => $e->getMessage()]);
}
?>
