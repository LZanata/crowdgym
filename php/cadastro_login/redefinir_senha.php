<?php
include('conexao.php');

if (isset($_GET['token']) && isset($_GET['tipo'])) {
    $token = $_GET['token'];
    $tipo_usuario = $_GET['tipo'];

    // Verificando se o token é válido
    $query = $conn->prepare("SELECT * FROM $tipo_usuario WHERE token_recuperacao = ? AND validade_token > NOW()");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // Exibir formulário para redefinir a senha
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nova_senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            // Atualiza a senha no banco de dados e invalide o token
            $updateQuery = $conn->prepare("UPDATE $tipo_usuario SET senha = ?, token_recuperacao = NULL, validade_token = NULL WHERE token_recuperacao = ?");
            $updateQuery->bind_param("ss", $nova_senha, $token);
            $updateQuery->execute();

            echo "Senha redefinida com sucesso!";
        }
    } else {
        echo "Token inválido ou expirado.";
    }
}
?>
