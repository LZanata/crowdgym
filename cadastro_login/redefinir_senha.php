<?php
$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/../php/conexao.php";

// Array com as tabelas de usuários
$tables = ['administrador', 'aluno', 'funcionarios'];
$user = null;
$tableName = null;

// Procura o token em cada tabela
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table
            WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $token_hash);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user !== null) {
            $tableName = $table; // Identifica a tabela correspondente
            break; // Sai do loop se o usuário for encontrado
        }

        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta para a tabela $table: " . $mysqli->error;
    }
}

// Verifica se o token foi encontrado
if ($user === null) {
    die("Token não encontrado.");
}

// Verifica se o token expirou
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("O token expirou.");
}

// Processa o formulário de redefinição de senha
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    // Verifica se as senhas correspondem
    if ($newPassword === $confirmPassword) {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Atualiza a senha no banco de dados
        $updateSql = "UPDATE $tableName
                      SET senha = ?, reset_token_hash = NULL, reset_token_expires_at = NULL
                      WHERE id = ?";

        $updateStmt = $mysqli->prepare($updateSql);

        if ($updateStmt) {
            $updateStmt->bind_param("si", $passwordHash, $user['id']);
            $updateStmt->execute();

            if ($updateStmt->affected_rows > 0) {
                echo "Senha alterada com sucesso. Você pode fazer login com sua nova senha.";
                header("Location: http://localhost/Projeto_CrowdGym/index.php");
                exit;
            } else {
                echo "Erro ao atualizar a senha. Por favor, tente novamente.";
            }

            $updateStmt->close();
        } else {
            echo "Erro ao preparar a consulta de atualização: " . $mysqli->error;
        }
    } else {
        echo "As senhas não correspondem. Tente novamente.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro_login/alterar_senha.css">
    <title>Recuperar Senha</title>
</head>

<body>
    <!--Tela de Recuperação de Senha-->
    <div class="page">
        <form method="POST" class="formLogin">
            <div class="titulo">
                <h1>Crowd Gym</h1>
            </div>
            <h2>Redefinir Senha</h2>
            <label for="new_password">Insira nova senha</label>
            <input type="password" name="new_password" placeholder="Inserir nova senha" maxlength="15" required />
            <label for="confirm_password">Confirme nova senha</label>
            <input type="password" name="confirm_password" placeholder="Confirmar nova senha" maxlength="15" required />
            <div class="botoes">
                <input type="submit" value="Alterar Senha" name="AlteraSenha"></input>
            </div>
        </form>
    </div>
</body>

</html>
