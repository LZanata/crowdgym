<?php
session_start();

// Verifica se o funcionário está logado
if (!isset($_SESSION['Academia_id']) || $_SESSION['usuario_tipo'] !== 'funcionario') {
    header("Location: login_academia.php");  // Redireciona para a página de login se não for funcionário
    exit();
}
?>
