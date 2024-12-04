<?php
include '../conexao.php';

// Recebe os dados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram recebidos corretamente
if (isset($data['academia_id'])) {
    $academia_id = $data['academia_id'];

    // Consulta para calcular o número de alunos treinando
    $queryFluxo = $conn->prepare("SELECT COUNT(*) AS total FROM entrada_saida WHERE Academia_id = ? AND data_saida IS NULL");
    $queryFluxo->bind_param("i", $academia_id);
    $queryFluxo->execute();
    
    if ($queryFluxo->error) {
        echo json_encode(['erro' => 'Erro ao calcular o fluxo: ' . $queryFluxo->error]);
        exit;
    }
    
    $resultado = $queryFluxo->get_result();
    $row = $resultado->fetch_assoc();
    $totalAlunosTreinando = $row['total'];

    echo json_encode(['alunos_treinando' => $totalAlunosTreinando]);
} else {
    echo json_encode(['erro' => 'Academia ID não informado.']);
}
?>
