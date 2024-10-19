<?php
require 'php/cadastro_login/verifica_login_gerente.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gráficos</title>
  <link rel="stylesheet" href="css/gerente/graficos.css">
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
              <a href="gerente_planos.php">Planos e Assinaturas</a>
              <a href="gerente_graficos.php">Gráficos</a>
              <a href="gerente_func.php">Funcionários</a>
              <a href="gerente_aluno.php">Alunos</a>
              <a href="gerente_sobre_nos.php">Sobre Nós</a>
              <a href="gerente_suporte.php">Ajuda e Suporte</a>
              <a href="tela_inicio.html">Sair</a>
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
    <!--Quando clicar nesta opção de tela aparecera: gráficos de fluxo(semanal, mensal, anual) - faixa etária dos alunos(criança, adolescente, adulto e idoso) - gráfico de matriculas(semanal, mensal e anual) - grafico de receita(semanal, mensal e anual)-->
    <section>
      <div class="chart-container">
        <!-- Importando a tabela no JavaScript-->
        <div class="quantiaAlunos">
          <canvas id="quantidadeAlunos"></canvas>
          <script src="js/gerente/quantidade_alunos.js"></script>
        </div>
        <div class="alunoMatriculado">
          <canvas id="alunosMatriculados"></canvas>
          <script src="js/gerente/alunos_matriculados.js"></script>
        </div>
        <div class="faixaEtaria">
          <canvas id="faixaEtaria"></canvas>
          <script src="js/gerente/faixa_etaria.js"></script>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div id="footer_copyright">
      &#169
      2024 FROM EASY SYSTEM LTDA
    </div>
  </footer>
</body>

</html>