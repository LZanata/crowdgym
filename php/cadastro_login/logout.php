<?php
// Iniciar a sessão
session_start();
// Destruir todas as variáveis de sessão
session_unset();
// Destruir a sessão
session_destroy();

header("Location: http://localhost/Projeto_CrowdGym/index.php");
exit;
?>
