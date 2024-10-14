<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeAcademia = $_POST['nomeAcademia'];
    $nomeGerente = $_POST['nomeGerente'];
    $telefoneAcademia = $_POST['telefoneAcademia'];
    $telefoneGerente = $_POST['telefoneGerente'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];

    
    $to = "lzanatabot@gmail.com";
    $subject = "Novo formulário preenchido por $nomeGerente";
    $body = "Nome da Academia: $nomeAcademia\nNome do(a) Gerente: $nomeGerente\n\nEmail: $email\n\nTelefone da Academia:  $telefoneAcademia\n\nTelefone do Gerente: $telefoneGerente\n\n Email do Gerente: $email\n\n CEP: $cep\n\nEstado: $estado\n\nBairro: $bairro\n\nRua: $rua\n\nNúmero: $numero\n\nComplemento: $complemento";
    $headers = "De: $email";
    
    if (mail($to, $subject, $body, $headers)) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Falhou ao enviar o e-mail.";
    }
}
?>
