<?php
include '../conexao.php';

// Verifica se os dados foram enviados via POST
if (isset($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['valor'], $_POST['duracao'], $_POST['tipo'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $duracao = $_POST['duracao'];
    $tipo = $_POST['tipo'];

    // Atualiza os dados do plano no banco de dados
    $query = "UPDATE planos SET nome = ?, descricao = ?, valor = ?, duracao = ?, tipo = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdisi", $nome, $descricao, $valor, $duracao, $tipo, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: http://localhost/Projeto_CrowdGym/gerente/planos_editar.php?id=$id&success=1");
        exit;
    } else {
        echo "Erro ao atualizar o plano. " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Dados do plano incompletos.";
}
?>
