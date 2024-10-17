<?php
session_start();
include 'conexao.php'; // Certifique-se de que a conexão com o banco está correta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta o banco de dados para encontrar o usuário
    $query = "SELECT cpf, nome, senha FROM gerente WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifica se a senha fornecida corresponde à senha no banco de dados
        if (password_verify($senha, $user['senha'])) {
            // Inicia a sessão para o usuário logado
            $_SESSION['usuario_cpf'] = $user['cpf'];
            $_SESSION['usuario_nome'] = $user['nome'];

            // Redireciona para a página inicial ou dashboard
            header('Location: http://localhost/Projeto_CrowdGym/gerente_menu_inicial.html');
            exit;
        } else {
            echo "Senha incorreta. Tente novamente.";
        }
    } else {
        echo "Usuário não encontrado. Verifique o email.";
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conexao);
?>