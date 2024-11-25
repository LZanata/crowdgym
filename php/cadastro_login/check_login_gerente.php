<?php
session_start();

// Verifica se o gerente está logado
if (!isset($_SESSION['Academia_id']) || $_SESSION['usuario_tipo'] !== 'gerente') {
    header("Location: login_academia.php");  // Redireciona para a página de login se não for gerente
    exit();
}
?>
