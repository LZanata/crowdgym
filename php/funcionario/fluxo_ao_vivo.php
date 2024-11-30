<?php
include '../conexao.php';

// Recebe os dados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram recebidos corretamente
if (isset($data['aluno_id']) && isset($data['academia_id'])) {
    $aluno_id = $data['aluno_id'];
    $academia_id = $data['academia_id'];

    // Verifica se o aluno está entrando ou saindo
    $queryEntrada = $conexao->prepare("
        INSERT INTO entrada_saida (data_entrada, Academia_id, Aluno_id)
        VALUES (NOW(), ?, ?)
    ");
    $queryEntrada->bind_param("ii", $academia_id, $aluno_id);
    $queryEntrada->execute();
    
    // Atualiza o número de alunos treinando ao vivo
    atualizarFluxo($academia_id, $conexao);
} else {
    echo json_encode(['erro' => 'Dados incompletos: aluno_id ou academia_id ausente.']);
}

// Função para atualizar o número de alunos treinando
function atualizarFluxo($academia_id, $conexao) {
    $queryFluxo = $conexao->prepare("SELECT COUNT(*) AS total FROM entrada_saida WHERE Academia_id = ? AND data_saida IS NULL");
    $queryFluxo->bind_param("i", $academia_id);
    $queryFluxo->execute();
    $resultado = $queryFluxo->get_result();
    $row = $resultado->fetch_assoc();
    $totalAlunosTreinando = $row['total'];

    // Atualiza o histórico de fluxo
    $queryHistorico = $conexao->prepare("
        INSERT INTO historico_fluxo (alunos_treinando, data_hora, Academia_id)
        VALUES (?, NOW(), ?)
    ");
    $queryHistorico->bind_param("ii", $totalAlunosTreinando, $academia_id);
    $queryHistorico->execute();
}
?>
