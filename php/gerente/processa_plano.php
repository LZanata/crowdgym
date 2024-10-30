<?php
include 'conexao.php';
session_start();

// Verifica se o gerente está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_academia.php");
    exit();
}

// Obtém o ID do gerente logado
$Gerente_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $duracao = $_POST['duracao'];
    $tipo = $_POST['tipo'];

    // Consulta para inserir o novo plano
    $query = "INSERT INTO planos (nome, descricao, valor, duracao, tipo, Gerente_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($query);
    $stmt->bind_param("ssdisi", $nome, $descricao, $valor, $duracao, $tipo, $Gerente_id);

    if ($stmt->execute()) {
        echo "Plano cadastrado com sucesso!";
        // Redireciona de volta à página de planos
        header("Location: gerente_planos.php");
        exit();
    } else {
        echo "Erro ao cadastrar o plano: " . $conexao->error;
    }

    // Fecha o statement
    $stmt->close();
}

// Fecha a conexão
$conexao->close();
?>
