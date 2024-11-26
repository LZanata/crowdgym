<?php
include '../conexao.php';

// Verifica se o ID foi fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Executa a exclusão do usuário no banco de dados
    $query = "DELETE FROM funcionarios WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // Tenta executar a query de exclusão
        if (mysqli_stmt_execute($stmt)) {
            // Redireciona para a página principal com uma mensagem de sucesso
            header("Location: http://localhost/Projeto_CrowdGym/gerente/gerente_func.php?removido=1");
            exit;
        } else {
            // Exibe um erro se a execução falhar
            header("Location: http://localhost/Projeto_CrowdGym/gerente/gerente_func.php?erro=1");
            exit;
        }
        
        mysqli_stmt_close($stmt);
    } else {
        // Exibe um erro caso a preparação da query falhe
        echo "Erro ao preparar a consulta: " . mysqli_error($conexao);
    }
} else {
    echo "ID do usuário não fornecido.";
}
?>
