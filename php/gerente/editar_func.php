<?php
include '../conexao.php';

// Verifica se o formulário foi enviado com o ID do usuário
if (isset($_POST['id'], $_POST['nome'], $_POST['email'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $data_contrat = $_POST['data_contrat'];
    $genero = $_POST['genero'];

    // Atualiza os dados do funcionário no banco de dados
    $query = "UPDATE funcionarios SET nome = ?, email = ?, cpf = ?, cargo = ?, data_contrat = ?, genero = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $nome, $email, $cpf, $cargo, $data_contrat, $genero, $id);

    if (mysqli_stmt_execute($stmt)) {
        // Redireciona o usuário de volta para a página de edição com uma mensagem de sucesso
        header("Location: http://localhost/Projeto_CrowdGym/gerente/funcionario_editar.php?id=$id&success=1");
        exit;
    } else {
        echo "Erro ao atualizar os dados: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Dados incompletos para atualização.";
}
?>
