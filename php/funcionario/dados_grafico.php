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

while ($linha = $resultado->fetch_assoc()) {
    $labels[] = $linha['hora'];
    $data[] = $linha['total'];
}

echo json_encode(['labels' => $labels, 'data' => $data]);
?>
