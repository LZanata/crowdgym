<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Minhas Academias</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/aluno/minhas_academias.css">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
  </head>
  <body>
    <header>
      <!--Quando clicar nesta opção tem que aparecer as academias que ele está matriculado no sistema e quando clicar na academia deverá mostrar os dados de quantas pessoas estão treinando e os planos assinados nesta academia. -->
      <nav>
        <!--Menu para alterar as opções de tela-->
        <div class="list">
          <ul>
            <li class="dropdown">
              <a href="#"><i class="bi bi-list"></i></a>

              <div class="dropdown-list">
                <a href="aluno_menu_inicial.php">Menu Inicial</a>
                <a href="aluno_minhas_academias.php">Minhas Academias</a>
                <a href="aluno_buscar_academias.php">Buscar Academias</a>
                <a href="aluno_dados_pagamento.php">Dados de Pagamento</a>
                <a href="aluno_sobre_nos.php">Sobre Nós</a>
                <a href="aluno_suporte.php">Ajuda e Suporte</a>
                <a href="php/cadastro_login/logout.php">Sair</a>
              </div>
            </li>
          </ul>
        </div>
        <!--Logo do Crowd Gym(quando passar o mouse por cima, o logo devera ficar laranja)-->
        <div class="logo">
          <h1>Crowd Gym</h1>
        </div>
        <!--Opção para alterar as configurações de usuário-->
        <div class="user">
          <ul>
            <li class="user-icon">
              <a href=""><i class="bi bi-person-circle"></i></a>

              <div class="dropdown-icon">
                <a href="#">Editar Perfil</a>
                <a href="#">Alterar Tema</a>
                <a href="#">Sair da Conta</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <main>
      <section class="mygym">
        <h1>NENHUMA ACADEMIA REGISTRADA</h1>
        <a href="">CLIQUE AQUI PARA BUSCAR UMA ACADEMIA</a>
      </section>
    </main>
    <footer>
      <div id="footer_copyright">
        &#169
        2024 CROWD GYM FROM EASY SYSTEM LTDA
      </div>
    </footer>
  </body>
</html>
