<?php
include 'conexao.php';

session_start();
if (!isset($_SESSION['gerente_id'])) {
    // Se o usuário não estiver logado, redireciona para o login
    header("Location: processar_login_academia.php");
    exit;
}
?>