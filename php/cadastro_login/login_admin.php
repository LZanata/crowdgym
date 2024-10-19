<?php
include 'conexao.php';

// Obtém os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Consulta para verificar o usuário no banco de dados
$sql = "SELECT * FROM administrador WHERE email = '$email' AND senha = '$senha'";
$result = $conn->query($sql);

// Verifica se há correspondência
if ($result->num_rows > 0) {
    // Redireciona para a página do administrador
    header("Location: http://localhost/Projeto_CrowdGym/admin_menu_academia.php");
    exit();
} else {
    // Falha no login
    echo "Email ou senha incorretos. Tente novamente.";
}

// Fecha a conexão
$conn->close();
?>           