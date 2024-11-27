<?php
include '../conexao.php';

// Captura fluxo atual
function registrarHistoricoFluxo($academia_id, $conexao) {
    $queryFluxo = $conexao->prepare("
        SELECT COUNT(*) AS total
        FROM entrada_saida
        WHERE Academia_id = ? AND data_saida IS NULL
    ");
    $queryFluxo->bind_param("i", $academia_id);
    $queryFluxo->execute();
    $resultado = $queryFluxo->get_result();
    $dados = $resultado->fetch_assoc();

    // Insere no histórico
    $queryHistorico = $conexao->prepare("
        INSERT INTO historico_fluxo (data_hora, alunos_treinando, Academia_id)
        VALUES (NOW(), ?, ?)
    ");
    $queryHistorico->bind_param("ii", $dados['total'], $academia_id);
    $queryHistorico->execute();
}

$academia_id = $_SESSION['Academia_id'];
registrarHistoricoFluxo($academia_id, $conexao);
?>
