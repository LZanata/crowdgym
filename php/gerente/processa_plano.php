<?php
include '../conexao.php';
session_start();

// Verifica se o gerente está logado
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['Academia_id'])) {
    header("Location: login_academia.php");
    exit();
}

// Obtém o ID da academia associada ao gerente logado
$Academia_id = $_SESSION['Academia_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $duracao = $_POST['duracao'];
    $tipo = $_POST['tipo'];

    // Consulta para inserir o novo plano, vinculando ao Academia_id
    $query = "INSERT INTO planos (nome, descricao, valor, duracao, tipo, Academia_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdisi", $nome, $descricao, $valor, $duracao, $tipo, $Academia_id);

    if ($stmt->execute()) {
        // Redireciona de volta à página de planos
        header("Location: http://localhost/Projeto_CrowdGym/gerente/planos.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao cadastrar o plano: " . $conn->error;
    }

    // Fecha o statement
    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>
