<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeAcademia = $_POST['nomeAcademia'];
    $nomeGerente = $_POST['nomeGerente'];
    $email = $_POST['email'];

    
    $to = "lzanatabot@gmail.com";
    $subject = "Novo formulário preenchido por $nomeGerente";
    $body = "Nome da Academia: $nomeAcademia\nNome do(a) Gerente: $nomeGerente\n\nEmail:\n$email";
    $headers = "De: $email";
    
    if (mail($to, $subject, $body, $headers)) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Falhou ao enviar o e-mail.";
    }
}
?>
