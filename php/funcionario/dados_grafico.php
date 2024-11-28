<?php
include '../conexao.php';
session_start();

// Verificar se a sessão está ativa
if (!isset($_SESSION['Academia_id'])) {
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$academia_id = $_SESSION['Academia_id'];

// Verifique a conexão com o banco
if ($conexao->connect_error) {
    echo json_encode(['error' => 'Erro de conexão: ' . $conexao->connect_error]);
    exit;
}

// Consulta SQL para obter dados
$query = $conexao->prepare("
    SELECT DATE_FORMAT(data_hora, '%H:%i') AS hora, MAX(alunos_treinando) AS total
    FROM historico_fluxo
    WHERE Academia_id = ?
    GROUP BY HOUR(data_hora)
    ORDER BY data_hora ASC
");

$query->bind_param("i", $academia_id);
$query->execute();
$resultado = $query->get_result();

$labels = [];
$data = [];

// Verifique os dados retornados pela consulta
if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $labels[] = $linha['hora'];
        $data[] = $linha['total'];
    }
    echo json_encode(['labels' => $labels, 'data' => $data]);
} else {
    echo json_encode(['error' => 'Sem dados para mostrar']);
}
?>
