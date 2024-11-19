<?php
    session_start();
    
    if (!isset($_SESSION['aluno_id'])) {
        header("Location: login_aluno.php");
        exit;
    }
?>