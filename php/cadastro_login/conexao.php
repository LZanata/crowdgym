<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "crowdgym";

try {
    // Cria a conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configura o modo de erro do PDO para lançar exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em caso de erro, exibi a mensagem de erro
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>