<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $Academia_id = $_POST['Academia_id'];
    $tipo = 'gerente'; // Define o tipo como 'gerente'

    // Verifica se as senhas coincidem
    if ($senha !== $confirma_senha) {
        echo "Erro: As senhas não coincidem. Tente novamente.";
        exit; // Interrompe a execução se as senhas não coincidirem
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir os dados no banco de dados
    $query = "INSERT INTO funcionarios (cpf, nome, email, telefone, senha, tipo, Academia_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $cpf, $nome, $email, $telefone, $senha_hash, $tipo, $Academia_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Gerente cadastrado com sucesso!";
        // Redirecionar para outra página
        header("Location: http://localhost/Projeto_CrowdGym/administrador/admin_menu_academia.php");
        exit();
    } else {
        echo "Erro ao cadastrar o gerente: " . mysqli_error($conexao);
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conexao);
?>
