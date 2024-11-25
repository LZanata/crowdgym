<?php
$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "../php/conexao.php";

// Array com as tabelas de usuários
$tables = ['administrador', 'gerente', 'funcionario', 'aluno'];
$user = null;
$tableName = null;

foreach ($tables as $table) {
    $sql = "SELECT * FROM $table
            WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user !== null) {
        $tableName = $table;
        break; // Sai do loop se um usuário for encontrado
    }
}

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
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
                      WHERE id = ?"; // Use o identificador correto, pode ser `id` ou outro nome de coluna

        $updateStmt = $mysqli->prepare($updateSql);
        $updateStmt->bind_param("si", $passwordHash, $user['id']); // Ajuste conforme o identificador correto
        $updateStmt->execute();

        echo "Senha alterada com sucesso. Você pode fazer login com sua nova senha.";
        header("Location: http://localhost/Projeto_CrowdGym/tela_inicio.html");
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
