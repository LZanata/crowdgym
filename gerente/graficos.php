<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gráficos</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/gerente/graficos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Importando Chart.js -->
</head>

<body>
  <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->

  <main>
    <div class="chart-container">
      <!-- Gráfico de fluxo semanal/mensal/anual/etc... -->
      <div class="container_main">
        <div class="container_header">
          <h1>Quantidade de Alunos</h1>
        </div>
        <div class="container_content">
          <input type="hidden" id="academiaId" value="<?php echo $_SESSION['Academia_id']; ?>">
          <label for="intervaloFluxo">Selecione o intervalo de tempo:</label>
          <select id="intervaloFluxo" onchange="carregarGraficoFluxo()">
            <option value="7">Últimos 7 dias</option>
            <option value="30" selected>Últimos 30 dias</option>
            <option value="365">Últimos 365 dias</option>
          </select>
          <canvas id="graficoFluxo"></canvas>
        </div>
      </div>

      <!-- Gráfico de Fluxo por Hora -->
      <div class="container_main">
        <div class="container_header">
          <h1>Fluxo por Hora</h1>
        </div>
        <div class="container_content">
          <input type="hidden" id="academiaIdHora" value="<?php echo $_SESSION['Academia_id']; ?>">
          <label for="intervaloFluxoPorHora">Selecione o intervalo de tempo:</label>
          <select id="intervaloFluxoPorHora" onchange="carregarGraficoFluxoPorHora()">
            <option value="7">Últimos 7 dias</option>
            <option value="30" selected>Últimos 30 dias</option>
            <option value="365">Últimos 365 dias</option>
          </select>
          <canvas id="graficoFluxoPorHora"></canvas>
        </div>
      </div>
      <!-- Gráfico de alunos matriculados -->
      <div class="container_main">
        <div class="container_header">
          <h1>Alunos Matriculados</h1>
        </div>
        <div class="container_content">
          <label for="intervaloMatriculados">Selecione o intervalo de tempo:</label>
          <select id="intervaloMatriculados" onchange="carregarGraficoAlunosMatriculados()">
            <option value="7">Últimos 7 dias</option>
            <option value="30" selected>Últimos 30 dias</option>
            <option value="365">Últimos 365 dias</option>
          </select>
          <canvas id="alunosMatriculados"></canvas>
        </div>
      </div>
      <!--Gráfico de Taxa de Renovação de Planos-->
      <div class="container_main">
        <div class="container_header">
          <h1>Taxa de Renovação de Planos</h1>
        </div>
        <div class="container_content">
          <label for="intervaloTaxa">Selecione o intervalo de tempo:</label>
          <select id="intervaloTaxa" onchange="carregarTaxaRenovacao()">
            <option value="7">Últimos 7 dias</option>
            <option value="30" selected>Últimos 30 dias</option>
            <option value="365">Últimos 365 dias</option>
          </select>
          <canvas id="graficoTaxaRenovacao"></canvas>
        </div>
      </div>
      <!-- Gráfico de faixa etária -->
      <div class="container_main">
        <div class="container_header">
          <h1>Faixa Etária dos Alunos</h1>
        </div>
        <div class="container_content">
          <canvas id="faixaEtaria"></canvas>
        </div>
      </div>
    </div>
  </main>

  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
  <script src="../js/graficos/fluxo_diario.js"></script>
  <script src="../js/graficos/fluxo_por_hora.js"></script>
  <script src="../js/graficos/alunos_matriculados.js"></script>
  <script src="../js/graficos/taxa_renovacao.js"></script>
  <script src="../js/graficos/faixa_etaria.js"></script>
</body>

</html>