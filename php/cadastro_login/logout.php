<?php
// Iniciar a sessão
session_start();
// Destruir todas as variáveis de sessão
session_unset();
// Destruir a sessão
session_destroy();

header("Location: tela_inicio.html");
exit;
?>
