<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o usuário pelo e-mail
    $stmt = $pdo->prepare("SELECT * FROM gerente WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido, iniciar sessão
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        // Redirecionar para a página principal
        header("Location: http://localhost/Projeto_CrowdGym/gerente_menu_inicial.html");
        exit();
    } else {
        echo "E-mail ou senha incorretos.";
    }
}
?>
