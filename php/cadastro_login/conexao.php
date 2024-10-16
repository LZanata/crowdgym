<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "crowdgym";

// Cria a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica a conexão
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>