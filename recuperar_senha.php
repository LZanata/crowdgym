<?php
session_start();

include 'php/conexao.php';

require 'lib/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
use League\OAuth2\Client\Provider\Google;

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('conexao.php');

// Função para encontrar o usuário
function encontrarUsuario($conexao, $email) {
    $tabelas = ['administrador', 'gerente', 'funcionario', 'aluno'];
    foreach ($tabelas as $tabela) {
        $query = $conexao->prepare("SELECT email FROM $tabela WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        if ($result->num_rows > 0) {
            return $tabela; // Retorna o nome da tabela onde o e-mail foi encontrado
        }
    }
    return false; // E-mail não encontrado em nenhuma tabela
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $tipo_usuario = encontrarUsuario($conexao, $email);

    if ($tipo_usuario) {
        $token = bin2hex(random_bytes(16)); // Gerando um token
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Definindo a validade do token (1 hora)

        // Atualizando o token e sua validade na tabela do usuário
        $updateQuery = $conexao->prepare("UPDATE $tipo_usuario SET token_recuperacao = ?, validade_token = ? WHERE email = ?");
        $updateQuery->bind_param("sss", $token, $expiry, $email);
        $updateQuery->execute();

        // Gerando o link para redefinir a senha
        $link = "http://localhost/Projeto_CrowdGym/redefinir_senha.php?token=$token&tipo=$tipo_usuario";
        $assunto = "Recuperação de Senha";
        $mensagem = "Olá, clique no link abaixo para redefinir sua senha: $link";

        // Configuração do OAuth 2.0
        $provider = new Google([
            'clientId'     => getenv('GOOGLE_CLIENT_ID'),
            'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => 'http://localhost',
        ]);

        $accessToken = getenv('GOOGLE_ACCESS_TOKEN'); // Token de acesso obtido anteriormente

        // Configuração do PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuração do OAuth 2.0 no PHPMailer
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(new \PHPMailer\PHPMailer\OAuth([
                'provider' => $provider,
                'clientId' => getenv('GOOGLE_CLIENT_ID'),
                'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
                'refreshToken' => getenv('GOOGLE_REFRESH_TOKEN'),
                'userName' => getenv('EMAIL_USUARIO')
            ]));

            // Definindo remetente e destinatário
            $mail->setFrom(getenv('EMAIL_USUARIO'), 'Crowd Gym');
            $mail->addAddress($email);

            // Assunto e corpo do e-mail
            $mail->Subject = $assunto;
            $mail->Body    = $mensagem;

            // Enviar o e-mail
            $mail->send();
            echo 'E-mail de recuperação enviado com sucesso.';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    } else {
        echo "E-mail não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cadastro_login/recuperar_senha.css">
    <title>Recuperar Senha</title>
</head>

<body>
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
