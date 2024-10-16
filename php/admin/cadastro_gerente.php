<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $Academia_id = $_POST['Academia_id'];

    // Verifica se as senhas coincidem
    if ($senha !== $confirma_senha) {
        echo "Erro: As senhas não coincidem. Tente novamente.";
        exit; // Interrompe a execução se as senhas não coincidirem
    } else {

    // Inserir os dados no banco de dados
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha
    $query = "INSERT INTO gerente (cpf, nome, email, telefone, senha, Academia_id) VALUES ('$cpf','$nome', '$email', '$telefone', '$senha_hash', '$Academia_id')";

    if (mysqli_query($conexao, $query)) {
        echo "Usuário cadastrado com sucesso!";
        // Redirecionar para outra página
        header("Location: http://localhost/Projeto_CrowdGym/admin_menu_academia.html");
        exit();
    } else {
        echo "Erro ao cadastrar o usuário: " . mysqli_error($conexao);
    }
}
}

?>