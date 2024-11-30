<?php
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

function atualizarHistoricoFluxo($academia_id, $conexao) {
    $alunosTreinando = contarAlunosTreinando($academia_id, $conexao);

    $queryHistorico = $conexao->prepare("
        INSERT INTO historico_fluxo (alunos_treinando, data_hora, Academia_id)
        VALUES (?, NOW(), ?)
    ");
    $queryHistorico->bind_param("ii", $alunosTreinando, $academia_id);

    if (!$queryHistorico->execute()) {
        error_log("Erro ao atualizar histórico: " . $queryHistorico->error);
    }
}

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
    $alunosTreinando = contarAlunosTreinando($academia_id, $conexao);

    if ($alunosTreinando > $capacidadeMaxima) {
        enviarNotificacao($alunosTreinando, $capacidadeMaxima);
    }
}

function enviarNotificacao($alunos, $limite) {
    echo "Atenção: $alunos alunos na academia. Capacidade máxima: $limite.";
}
?>
