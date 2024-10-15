<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Encriptação da senha
    $confirma_senha = $_POST['confirma_senha'];
    $Academia_id = $_POST['Academia_id'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirma_senha) {
        echo "Erro: As senhas não coincidem. Tente novamente.";
        exit; // Interrompe a execução se as senhas não coincidirem
    }

    // Inserir os dados no banco de dados
    $query = "INSERT INTO gerente (cpf, nome, email, telefone, senha, Academia_id) VALUES ('$cpf','$nome', '$email', '$senha', '$Academia_id')";

    if (mysqli_query($conexao, $query)) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o usuário: " . mysqli_error($conexao);
    }
}

?>