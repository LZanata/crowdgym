<?php
include('conexao.php');

function encontrarUsuario($conn, $email)
{
    $tabelas = ['administradores', 'gerentes', 'funcionarios', 'alunos'];
    foreach ($tabelas as $tabela) {
        $query = $conn->prepare("SELECT '$tabela' AS tipo_usuario FROM $tabela WHERE email = ?");
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

    $tipo_usuario = encontrarUsuario($conn, $email);

    if ($tipo_usuario) {
        // Gerando um token seguro
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $updateQuery = $conn->prepare("UPDATE $tipo_usuario SET token_recuperacao = ?, validade_token = ? WHERE email = ?");
        $updateQuery->bind_param("sss", $token, $expiry, $email);
        $updateQuery->execute();

        // Enviar e-mail de recuperação
        $link = "https://seusite.com/redefinir_senha.php?token=$token&tipo=$tipo_usuario";
        $assunto = "Recuperação de Senha";
        $mensagem = "Olá, clique no link abaixo para redefinir sua senha: $link";
        $headers = "From: no-reply@seusite.com";

        if (mail($email, $assunto, $mensagem, $headers)) {
            echo "Um link de recuperação foi enviado para o seu e-mail.";
        } else {
            echo "Falha ao enviar o e-mail. Tente novamente.";
        }
    } else {
        echo "E-mail não encontrado.";
    }
}
?>