<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda e Suporte</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/gerente/suporte.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/funcionario/suporte.css">
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6827a6cd36f29c190d216342/1irdh4qa7';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body>
    <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->
    <main>
        <!--Quando clicar aparecerá a tela para enviar uma mensagem ou tickets para o suporte técnico-->
        <section class="support-section">
            <h2>Ajuda e Suporte</h2>
            <p>Preencha o formulário abaixo para abrir um ticket de suporte. Nossa equipe entrará em contato em breve.</p>

            <form action="enviar_ticket.php" method="POST" class="support-form">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">

                <label for="mensagem">Descrição do Problema:</label>
                <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Descreva o problema"></textarea>

                <button type="submit" class="submit-btn">Enviar Ticket</button>
            </form>
        </section>
    </main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>