<?php
session_start();

if (!isset($_SESSION['administrador_id'])) {
    // Redireciona para a página de login, caso a sessão não exista
    header("Location: http://localhost/Projeto_CrowdGym/cadastro_login/login_admin.php");
    exit();
}
?>
