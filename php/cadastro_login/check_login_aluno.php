<?php
    session_start();
    
    if (!isset($_SESSION['aluno_id'])) {
        header("Location: http://localhost/Projeto_CrowdGym/cadastro_login/login_aluno.php");
        exit;
    }
?>