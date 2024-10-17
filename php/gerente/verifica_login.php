<?php
session_start();

// Verifica se o gerente está logado
if (!isset($_SESSION['gerente_id'])) {
    // Redireciona para a página de login se o gerente não estiver logado
    header("Location: http://localhost/Projeto_CrowdGym/login_academia.html");
    exit();
}
?>
