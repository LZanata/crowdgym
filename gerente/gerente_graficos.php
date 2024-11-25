<?php include 'php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gráficos</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/gerente/graficos.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- Importando a biblioteca Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <?php include 'partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <!--Quando clicar nesta opção de tela aparecera: gráficos de fluxo(semanal, mensal, anual) - faixa etária dos alunos(criança, adolescente, adulto e idoso) - gráfico de matriculas(semanal, mensal e anual) - grafico de receita(semanal, mensal e anual)-->
    <section>
      <div class="chart-container">
        <!-- Importando a tabela no JavaScript-->
        <div class="container_main">
          <div class="container_header">
            <h1>Quantidade de Alunos</h1>
          </div>
          <div class="quantia_main">
            <canvas id="quantidadeAlunos"></canvas>
            <script src="js/gerente/quantidade_alunos.js"></script>
          </div>
        </div>
        <div class="container_main">
          <div class="container_header">
            <h1>Alunos Matriculados</h1>
          </div>
          <div class="matriculados_main">
            <canvas id="alunosMatriculados"></canvas>
            <script src="js/gerente/alunos_matriculados.js"></script>
          </div>
        </div>
        <div class="container_main">
          <div class="container_header">
            <h1>Faixa Etária dos Alunos</h1>
          </div>
          <div class="faixa_main">
            <canvas id="faixaEtaria"></canvas>
            <script src="js/gerente/faixa_etaria.js"></script>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include 'partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>