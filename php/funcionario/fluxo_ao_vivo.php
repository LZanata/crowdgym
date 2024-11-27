<?php
include '../conexao.php';
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['Academia_id'])) {
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

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
?>
