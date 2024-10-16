<?php
include 'conexao.php'; // Inclui a conexão com o banco de dados
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o usuário pelo e-mail
    $query = "SELECT * FROM gerente WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $usuario = mysqli_fetch_assoc($resultado);

    // Verificar se o usuário foi encontrado e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Iniciar sessão e salvar informações do usuário
        $_SESSION['cpf'] = $usuario['cpf'];
        $_SESSION['nome'] = $usuario['nome'];

        // Redirecionar para a página principal
        header("Location: http://localhost/Projeto_CrowdGym/gerente_menu_inicial.html");
        exit();
    } else {
        echo "E-mail ou senha incorretos.";
    }

    // Liberar o resultado e fechar a declaração
    mysqli_stmt_close($stmt);
}
?>
