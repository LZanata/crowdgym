<?php
session_start();
session_destroy(); // Encerra a sessão

// Redireciona para a página de login
header("Location: login_academia.html");
exit();
?>
