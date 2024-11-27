<?php
include '../conexao.php';
session_start();

if (!isset($_SESSION['Academia_id'])) {
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$academia_id = $_SESSION['Academia_id'];

// Consulta para obter dados agrupados por hora
$query = $conexao->prepare("
    SELECT DATE_FORMAT(data_entrada, '%H:%i') AS hora, COUNT(*) AS total
    FROM entrada_saida
    WHERE Academia_id = ? AND data_saida IS NULL
    GROUP BY DATE_FORMAT(data_entrada, '%H:%i')
    ORDER BY data_entrada ASC
");
$query->bind_param("i", $academia_id);
$query->execute();
$resultado = $query->get_result();

$labels = [];
$data = [];

while ($linha = $resultado->fetch_assoc()) {
    $labels[] = $linha['hora'];
    $data[] = $linha['total'];
}

var_dump(['labels' => $labels, 'data' => $data]);
echo json_encode(['labels' => $labels, 'data' => $data]);
?>
