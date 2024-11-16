<?php
require '.../.../lib/vendor/autoload.php'; 

// Verifica se o código de autorização foi recebido na URL
if (isset($_GET['code'])) {
    $authorizationCode = $_GET['code'];

    // Aqui troca o código de autorização pelo token de acesso
    echo "Código de autorização recebido: " . htmlspecialchars($authorizationCode);
} else {
    echo "Nenhum código de autorização foi recebido.";
}
?>