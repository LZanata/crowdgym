<?php

if (isset($_POST['SendRecupSenha'])) {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Gera o token e configura a expiração
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 60 * 30); // Token válido por 30 minutos

        // Inclui a conexão com o banco de dados
        $conn = require __DIR__ . "/../php/conexao.php";

        // Array com as tabelas de usuários
        $tables = ['administrador', 'aluno', 'funcionarios'];
        $emailFound = false;

        // Percorre as tabelas para atualizar o token
        foreach ($tables as $table) {
            $sql = "UPDATE $table
                    SET reset_token_hash = ?, reset_token_expires_at = ?
                    WHERE email = ?";

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $token_hash, $expiry, $email);
                $stmt->execute();

                // Verifica se o e-mail foi encontrado
                if ($conn->affected_rows) {
                    $emailFound = true;
                    break; // Sai do loop se o e-mail for encontrado
                }
                $stmt->close();
            } else {
                echo "Erro ao preparar a consulta para a tabela $table: " . $conn->error;
            }
        }

        // Envia o e-mail se o e-mail foi encontrado em alguma tabela
        if ($emailFound) {
            $mail = require __DIR__ . "/../lib/phpmailer/mailer.php";

            $mail->setFrom("crowdgym21@gmail.com");
            $mail->addAddress($email);
            $mail->Subject = "Crowd Gym - Alterar Senha";
            $mail->Body = <<<END
Clique <a href="http://localhost/Projeto_CrowdGym/cadastro_login/redefinir_senha.php?token=$token">aqui</a> 
para alterar a sua senha.
END;

            try {
                $mail->send();
                echo "Email enviado, por favor verifique o seu inbox.";
            } catch (Exception $e) {
                echo "O email não pode ser enviado. Mailer error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Email não encontrado em nenhuma tabela.";
        }
    } else {
        echo "E-mail não foi fornecido.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastro_login/recuperar_senha.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Recuperar Senha</title>
</head>

<body>
    <div class="back-button">
        <a href="../index.php"><i class="bi bi-arrow-left-circle"></i></a>
    </div>
    <!--Tela de Recuperação de Senha-->
    <div class="page">
        <form method="POST" action="" class="formLogin">
            <div class="titulo">
                <h1>Crowd Gym</h1>
            </div>
            <h2>Redefinir Senha</h2>
            <p>Para redefinir sua senha, informe o e-mail cadastrado na sua conta e lhe enviaremos um link para realizar a alteração</p>
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Inserir e-mail" autofocus="true" required />
            <div class="botoes">
                <input type="submit" value="Enviar link para alteração" name="SendRecupSenha"></input>
            </div>
        </form>
    </div>
</body>

</html>