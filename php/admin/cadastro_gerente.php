<?php
include 'php/conexao.php';

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
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir os dados no banco de dados
    $query = "INSERT INTO gerente (cpf, nome, email, telefone, senha, Academia_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $cpf, $nome, $email, $telefone, $senha_hash, $Academia_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Usuário cadastrado com sucesso!";
        // Redirecionar para outra página
        header("Location: http://localhost/Projeto_CrowdGym/admin_menu_academia.php");
        exit();
    } else {
        echo "Erro ao cadastrar o usuário: " . mysqli_error($conexao);
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conexao);
?>