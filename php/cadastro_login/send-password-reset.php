<?php
$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/conexao.php";

// Array com as tabelas de usuários
$tables = ['administrador', 'gerente', 'funcionario', 'aluno'];

$user = null;

// Iterar sobre as tabelas de usuários para procurar o token
foreach ($tables as $table) {
    $sql = "SELECT * FROM $table WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Se o token for encontrado, define o usuário e sai do loop
    if ($user = $result->fetch_assoc()) {
        break;
    }
}

if ($user === null) {
    die("Token não encontrado");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("Token expirado");
}

if (strlen($_POST["senha"]) < 8) {
    die("A senha deve ter pelo menos 8 caracteres");
}

if (!preg_match("/[a-z]/i", $_POST["senha"])) {
    die("A senha deve conter pelo menos uma letra");
}

if (!preg_match("/[0-9]/", $_POST["senha"])) {
    die("A senha deve conter pelo menos um número");
}

if ($_POST["senha"] !== $_POST["senha_confirmation"]) {
    die("As senhas devem coincidir");
}

$password_hash = password_hash($_POST["senha"], PASSWORD_DEFAULT);

// Atualizar a senha e remover o token
$sql = "UPDATE $table
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["id"]);
$stmt->execute();

echo "Senha atualizada. Agora você pode fazer login.";
?>
