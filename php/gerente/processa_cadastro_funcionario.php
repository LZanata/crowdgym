<?php
include '../conexao.php';
include '../cadastro_login/check_login_gerente.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $telefone = $_POST['telefone'] ?? null; // Exclusivo para gerente
    $cargo = $_POST['cargo'] ?? null;       // Exclusivo para funcionário
    $data_contrat = $_POST['data_contrat'] ?? null; // Exclusivo para funcionário
    $genero = $_POST['genero'] ?? null;     // Exclusivo para funcionário
    $tipo = $_POST['tipo'];
    $Academia_id = $_SESSION['Academia_id']; // Pega o ID da academia do gerente logado

    // Verifica se as senhas coincidem
    if ($senha !== $confirma_senha) {
        echo "Erro: As senhas não coincidem. Tente novamente.";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir os dados no banco de dados
    $query = "INSERT INTO funcionarios (cpf, nome, email, senha, telefone, cargo, data_contrat, genero, tipo, Academia_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssssssi', $cpf, $nome, $email, $senha_hash, $telefone, $cargo, $data_contrat, $genero, $tipo, $Academia_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Usuário cadastrado com sucesso!";
        // Redirecionar para outra página
        header("Location: http://localhost/Projeto_CrowdGym/gerente/funcionario.php");
        exit();
    } else {
        echo "Erro ao cadastrar o usuário: " . mysqli_error($conn);
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conn);
?>
