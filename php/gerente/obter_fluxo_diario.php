<?php
header('Content-Type: application/json');

try {
    include '../conexao.php';

    // Verifica se os parâmetros necessários estão presentes
    if (!isset($_GET['academia_id']) || !isset($_GET['intervalo'])) {
        throw new Exception("Parâmetros ausentes.");
    }

    // Obtém os valores dos parâmetros
    $academia_id = intval($_GET['academia_id']);
    $intervalo = $_GET['intervalo'];

    // Mapeamento do intervalo para número de dias
    $intervalMapping = [
        'semanal' => 7,
        'mensal' => 30,
        'bimestral' => 60,
        'trimestral' => 90,
        'semestral' => 180,
        'anual' => 365
    ];

    // Verifica se o intervalo é válido
    if (!isset($intervalMapping[$intervalo])) {
        throw new Exception("Intervalo inválido.");
    }

    $dias = $intervalMapping[$intervalo];

    // Prepara a consulta ao banco de dados
    $query = $conexao->prepare("
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
    
    // Vincula os parâmetros na consulta
    $query->bind_param("ii", $academia_id, $dias);
    $query->execute();

    // Obtém os resultados
    $resultado = $query->get_result();
    $dados = ['labels' => [], 'values' => []];

    // Processa os resultados
    while ($row = $resultado->fetch_assoc()) {
        $dados['labels'][] = $row['dia'];
        $dados['values'][] = $row['total_alunos'];
    }

    // Retorna os dados em JSON
    echo json_encode($dados);
} catch (Exception $e) {
    // Retorna erro em formato JSON
    echo json_encode(['erro' => $e->getMessage()]);
}
