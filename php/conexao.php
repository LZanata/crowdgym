<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "crowdgym";

// Cria a conexão
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Retorna a conexão
return $conn;
?>
