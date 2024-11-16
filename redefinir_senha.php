<?php

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/php/conexao.php";

// Array com as tabelas de usuários
$tables = ['administrador', 'gerente', 'funcionario', 'aluno'];
$user = null;

foreach ($tables as $table) {
    $sql = "SELECT * FROM $table
            WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user !== null) {
        break; // Sai do loop se um usuário for encontrado
    }
}

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro_login/alterar_senha.css">
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
            <label for="password">Insira nova senha</label>
            <input type="password" placeholder="Inserir nova senha" maxlength="15" autofocus="true" required />
            <label for="password">Confirme nova senha</label>
            <input type="password" placeholder="Confirmar nova senha" maxlength="15" autofocus="true" required />
            <div class="botoes">
                <a href="tela_inicio.html">Alterar senha</a>
            </div>
        </form>
    </div>
</body>

</html>