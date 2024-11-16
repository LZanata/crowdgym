<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

// Configurações de OAuth
$clientId = 'SEU_CLIENT_ID'; // Substitua pelo seu Client ID
$clientSecret = 'SEU_CLIENT_SECRET'; // Substitua pelo seu Client Secret
$refreshToken = 'SEU_REFRESH_TOKEN'; // Substitua pelo seu Refresh Token
$emailUsuario = 'SEU_EMAIL@gmail.com'; // Substitua pelo seu e-mail

// Inicialização do PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;

    // Configuração de autenticação OAuth
    $mail->AuthType = 'XOAUTH2';
    $provider = new Google([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]);

    $mail->setOAuth(new OAuth([
        'provider' => $provider,
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'refreshToken' => $refreshToken,
        'userName' => $emailUsuario,
    ]));

    // Configuração do e-mail
    $mail->setFrom($emailUsuario, 'Seu Nome');
    $mail->addAddress('destinatario@example.com'); // Substitua pelo e-mail do destinatário

    // Assunto e corpo do e-mail
    $mail->Subject = 'Assunto do e-mail';
    $mail->Body = 'Conteúdo do e-mail';

    // Enviar o e-mail
    $mail->send();
    echo 'E-mail enviado com sucesso.';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
