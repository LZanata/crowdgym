<?php
include '../conexao.php';
include '../cadastro_login/check_login_funcionario.php';
include '../funcoes/funcoes_fluxo.php';

// Recebe os dados via POST e decodifica o JSON
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram recebidos corretamente
if (isset($data['aluno_id']) && isset($data['academia_id'])) {
    $aluno_id = $data['aluno_id'];
    $academia_id = $data['academia_id'];

    // Debug: log dos dados recebidos para verificar
    error_log("Dados recebidos: aluno_id = $aluno_id, academia_id = $academia_id");

    // Atualiza o fluxo de alunos
    $alunosTreinando = contarAlunosTreinando($academia_id, $conexao);
    echo json_encode(['alunos_treinando' => $alunosTreinando]);

    // Após inserir um novo registro de entrada
    $queryEntrada = $conexao->prepare("
        INSERT INTO entrada_saida (data_entrada, Academia_id, Aluno_id)
        VALUES (NOW(), ?, ?)
    ");
    $queryEntrada->bind_param("ii", $academia_id, $aluno_id);
    $queryEntrada->execute();

    // Atualiza o histórico de fluxo
    atualizarHistoricoFluxo($academia_id, $conexao);

    // Atualiza a saída do aluno
    $querySaida = $conexao->prepare("
        UPDATE entrada_saida
        SET data_saida = NOW()
        WHERE Aluno_id = ? AND Academia_id = ? AND data_saida IS NULL
    ");
    $querySaida->bind_param("ii", $aluno_id, $academia_id);
    $querySaida->execute();

    // Atualiza o histórico de fluxo novamente
    atualizarHistoricoFluxo($academia_id, $conexao);
} else {
    // Se os dados estão ausentes, envia uma resposta de erro
    echo json_encode(['erro' => 'Dados incompletos: aluno_id ou academia_id ausente.']);
}
?>
