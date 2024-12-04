<?php
include '../conexao.php';

// Verifica se o ID foi enviado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara a consulta para remover o plano com o ID especificado
    $query = "DELETE FROM planos WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Executa a consulta e verifica se a remoção foi bem-sucedida
    if (mysqli_stmt_execute($stmt)) {
        // Redireciona para a página principal com uma mensagem de sucesso
        header("Location: http://localhost/Projeto_CrowdGym/gerente/planos.php?removido=1");
    } else {
        // Em caso de erro, redireciona com uma mensagem de erro
        header("Location: http://localhost/Projeto_CrowdGym/gerente/planos.php?removido=0");
        exit;
    }

    mysqli_stmt_close($stmt);
} else {
    echo "ID do plano não fornecido.";
}
?>
