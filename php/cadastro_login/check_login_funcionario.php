<?php
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['Academia_id']) || $_SESSION['usuario_tipo'] !== 'funcionario') {
    header("Location: http://localhost/Projeto_CrowdGym/cadastro_login/login_academia.php");  // Redireciona para a página de login se não for funcionário
    exit();
}
?>
