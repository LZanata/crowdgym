<?php
require_once '../php/cadastro_login/check_login_aluno.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações Aluno</title>
    <link rel="stylesheet" href="../css/index.css">
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
    <!--Quando clicar aparecerá as opções para o usuario poder fazer alterar: conta(nome do aluno, email, autenticação de dois fatores e senha) - tema(claro ou escuro) -->
    <?php include '../partials/header_aluno.php'; ?> <!-- Inclui o cabeçalho -->
    <main></main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>