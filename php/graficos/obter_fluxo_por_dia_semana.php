<?php
// Ativar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexao.php';

try {
    // ID da academia (opcional)
    $academiaId = isset($_GET['academiaId']) ? (int) $_GET['academiaId'] : null;

    // Construção da consulta SQL
    $sql = "
        SELECT 
            DAYOFWEEK(data_entrada) AS dia_semana,  -- Usando DAYOFWEEK para identificar o dia da semana como número (1=Domingo, 7=Sábado)
            COUNT(*) / COUNT(DISTINCT DATE(data_entrada)) AS media_alunos
        FROM 
            entrada_saida
        WHERE 
            data_entrada >= CURDATE() - INTERVAL 365 DAY
    ";

    // Condicional para filtrar pela academia, se necessário
    if ($academiaId) {
        $sql .= " AND Academia_id = ?";
    }

    $sql .= "
        GROUP BY 
            dia_semana
        ORDER BY 
            dia_semana  -- Ordenar pela sequência de dias da semana
    ";

    // Prepara a consulta
    $stmt = $conn->prepare($sql);

    // Vincula o parâmetro academiaId, se fornecido
    if ($academiaId) {
        $stmt->bind_param("i", $academiaId);
    }

    // Executa a consulta
    $stmt->execute();

    // Obtém o resultado da consulta
    $result = $stmt->get_result();

    // Array para armazenar os resultados
    $data = [];

    // Loop para obter os dados
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Verificar se há resultados
    if (empty($data)) {
        echo json_encode(['erro' => 'Nenhum dado encontrado para este período.']);
    } else {
        // Retorna os dados em formato JSON
        echo json_encode($data);
    }

} catch (Exception $e) {
    // Retorna o erro em formato JSON
    echo json_encode(['erro' => $e->getMessage()]);
}
?>
