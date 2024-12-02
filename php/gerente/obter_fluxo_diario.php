<?php
header('Content-Type: application/json');
try {
    include '../conexao.php';

    if (!isset($_GET['academia_id']) || !isset($_GET['intervalo'])) {
        throw new Exception("Parâmetros ausentes.");
    }

    $academia_id = intval($_GET['academia_id']);
    $intervalo = $_GET['intervalo'];

    $intervalMapping = [
        'semanal' => '7 DAY',
        'mensal' => '30 DAY',
        'bimestral' => '60 DAY',
        'trimestral' => '90 DAY',
        'semestral' => '180 DAY',
        'anual' => '365 DAY'
    ];

    $periodo = $intervalMapping[$intervalo] ?? '7 DAY';

    $query = $conexao->prepare("
        SELECT 
            DATE(data_entrada) AS dia,
            COUNT(*) AS total_alunos
        FROM 
            entrada_saida
        WHERE 
            Academia_id = ? AND data_entrada >= NOW() - INTERVAL $periodo
        GROUP BY 
            DATE(data_entrada)
        ORDER BY 
            dia;
    ");
    $query->bind_param("i", $academia_id);
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
