<?php
include 'conexao.php';

// Verifica se o ID foi fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Executa a exclusão do usuário no banco de dados
    $query = "DELETE FROM funcionario WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    if (mysqli_stmt_execute($stmt)) {
        // Redireciona para a página principal com uma mensagem de sucesso
        header("Location: gerente_func.php?removido=1");
        exit;
    } else {
        echo "Erro ao remover o usuário: " . mysqli_error($conexao);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "ID do usuário não fornecido.";
}
?>
