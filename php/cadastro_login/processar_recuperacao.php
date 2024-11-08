<?php

require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Carregar variáveis de ambiente
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('conexao.php'); 

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
        $link = "localhost//Projeto_CrowdGym/redefinir_senha.php?token=$token&tipo=$tipo_usuario";
        $assunto = "Recuperação de Senha";
        $mensagem = "Olá, clique no link abaixo para redefinir sua senha: $link";

        // Configuração do PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('EMAIL_USUARIO');
            $mail->Password = getenv('EMAIL_SENHA');
            $mail->SMTPSecure = getenv('SMTP_SECURE');
            $mail->Port = getenv('SMTP_PORT');
        
            // Definindo remetente e destinatário
            $mail->setFrom(getenv('EMAIL_USUARIO'), 'Crowd Gym');
            $mail->addAddress($email); // E-mail do destinatário

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
