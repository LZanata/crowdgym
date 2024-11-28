<?php
include '../conexao.php';
include '../cadastro_login/check_login_funcionario.php';

$academia_id = $_SESSION['Academia_id'];

// Função para contar alunos treinando
function contarAlunosTreinando($academia_id, $conexao) {
    $query = $conexao->prepare("
        SELECT COUNT(*) AS total
        FROM entrada_saida
        WHERE Academia_id = ? AND data_saida IS NULL
    ");
    $query->bind_param("i", $academia_id);
    $query->execute();
    $resultado = $query->get_result();
    $dados = $resultado->fetch_assoc();

    return $dados['total'];
}

$alunosTreinando = contarAlunosTreinando($academia_id, $conexao);

echo json_encode(['alunos_treinando' => $alunosTreinando]);

function verificarCapacidade($academia_id, $conexao) {
    $query = $conexao->prepare("
        SELECT capacidade_maxima
        FROM academia
        WHERE id = ?
    ");
    $query->bind_param("i", $academia_id);
    $query->execute();
    $resultado = $query->get_result();
    $dadosAcademia = $resultado->fetch_assoc();

    $capacidadeMaxima = $dadosAcademia['capacidade_maxima'];

    // Conta alunos treinando
    $alunosTreinando = contarAlunosTreinando($academia_id, $conexao);

    if ($alunosTreinando > $capacidadeMaxima) {
        // Enviar notificação
        enviarNotificacao($alunosTreinando, $capacidadeMaxima);
    }
}

function enviarNotificacao($alunos, $limite) {
    // Código para enviar notificação (exemplo: e-mail ou pop-up)
    echo "Atenção: $alunos alunos na academia. Capacidade máxima: $limite.";
}
?>
