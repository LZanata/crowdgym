<?php include 'php/cadastro_login/check_login-funcionarios.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Inicial Gerente</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/gerente/menu_inicial.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- Importando a biblioteca Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <header>
    <nav>
      <!--Menu para alterar as opções de tela-->
      <div class="list">
        <ul>
          <li class="dropdown">
            <a href="#"><i class="bi bi-list"></i></a>

            <div class="dropdown-list">
              <a href="gerente_menu_inicial.php">Menu Inicial</a>
              <a href="gerente_planos.php">Planos e Serviços</a>
              <a href="gerente_graficos.php">Gráficos</a>
              <a href="gerente_func.php">Funcionários</a>
              <a href="gerente_aluno.php">Alunos</a>
              <a href="gerente_sobre_nos.php">Sobre Nós</a>
              <a href="gerente_suporte.php">Ajuda e Suporte</a>
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
              <a href="#">Perfil</a>
              <a href="#">Endereço</a>
              <a href="#">Tema</a>
              <a href="#">Sair</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main>
    <!--Este menu terá: Quantidade de Alunos Presentes - Gráfico de Fluxo Diário - Identificação das ultimas matriculas realizadas(aparecerá os 3 ultimos alunos que se matricularam)-->
      <section>
        <div class="chart-container">
          <canvas id="quantidadeAlunos"></canvas>
        </div>
        <!-- Importando a tabela no JavaScript-->
        <script src="js/gerente/quantidade_alunos.js"></script>
        <div class="conteudo_lista">
          <div class="lista_alunos">
            <div class="lista_header">
              <h1>Ultimas Matriculas Realizadas</h1>
            </div>
          </div>
          <div class="lista_principal">

          </div>
        </div>
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