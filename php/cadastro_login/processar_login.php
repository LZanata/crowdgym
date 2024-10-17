<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o gerente pelo email
    $query = "SELECT * FROM gerente WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se o gerente foi encontrado
    if ($row = mysqli_fetch_assoc($result)) {
        // Verifica se a senha está correta
        if (password_verify($senha, $row['senha'])) {
            // Inicia a sessão e salva os dados do usuário
            session_start();
            $_SESSION['gerente_id'] = $row['id'];
            $_SESSION['gerente_nome'] = $row['nome'];
            
            // Redireciona para a página do gerente
            header("Location: http://localhost/Projeto_CrowdGym/gerente_menu_inicial.html");
            exit();
        } else {
            echo "Senha incorreta. Tente novamente.";
        }
    } else {
        echo "Email não encontrado. Tente novamente.";
    }

    // Fecha o statement
    mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conexao);
?>
