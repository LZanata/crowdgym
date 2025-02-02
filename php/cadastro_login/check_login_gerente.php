<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o gerente está logado e se o Academia_id está na sessão
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'gerente' || !isset($_SESSION['Academia_id'])) {
    header("Location: http://localhost/Projeto_CrowdGym/cadastro_login/login_academia.php");
    exit();
}
?>
