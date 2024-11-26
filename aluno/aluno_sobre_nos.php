<?php
require_once '../php/cadastro_login/check_login_aluno.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sobre Nós</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/aluno/sobre_nos.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
  <nav>
    <!--Menu para alterar as opções de tela-->
    <?php include '../partials/header_aluno.php'; ?> <!-- Inclui o cabeçalho -->
    <?php include '../partials/main_sobre_nos.php'; ?> <!-- Inclui o Sobre Nós -->
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>