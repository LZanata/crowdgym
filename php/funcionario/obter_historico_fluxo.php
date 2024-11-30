<?php
include '../conexao.php';
include '../cadastro_login/check_login_funcionario.php';

// Exemplo de consulta ao banco para obter o histórico de fluxo
$query = "SELECT alunos_treinando, data_hora FROM historico_fluxo WHERE Academia_id = ? ORDER BY data_hora DESC LIMIT 10";
$stmt = $conexao->prepare($query);
$stmt->bind_param("i", $_SESSION['Academia_id']);
$stmt->execute();
$result = $stmt->get_result();

// Prepare os dados para o gráfico
$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = date('H:i', strtotime($row['data_hora']));  // Formatar para hora:minuto
    $values[] = $row['alunos_treinando'];
}

// Retorne os dados no formato JSON
echo json_encode([
    'labels' => $labels,
    'values' => $values
]);
?>
