<?php
include 'conexao.php';

if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['cpf']) && isset($_POST['cargo']) && isset($_POST['data_contrat']) && isset($_POST['genero'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $cargo = $_POST['cargo'];
    $data_contrat = $_POST['data_contrat'];
    $genero = $_POST['genero'];

    // Atualiza os dados do funcionário
    $query = "UPDATE funcionario SET nome = ?, email = ?, cpf = ?, cargo = ?, data_contrat = ?, genero = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $nome, $email, $cpf, $cargo, $data_contrat, $genero, $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Funcionário atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar funcionário.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Dados incompletos para a atualização.";
}
?>
