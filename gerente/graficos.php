<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gráficos</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/gerente/graficos.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- Importando a biblioteca Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <!--Quando clicar nesta opção de tela aparecera: gráficos de fluxo(semanal, mensal, anual) - faixa etária dos alunos(criança, adolescente, adulto e idoso) - gráfico de matriculas(semanal, mensal e anual) - grafico de receita(semanal, mensal e anual)-->
    <section>
      <div class="chart-container">
        <!-- Importando a tabela no JavaScript-->
        <div class="container_main">
          <div class="container_header">
            <h1>Quantidade de Alunos</h1>
          </div>
          <div class="fluxo_diario">
            <input type="hidden" id="academiaId" value="<?php echo $_SESSION['Academia_id']; ?>"><!-- Exemplo: ID da academia -->
            <label for="intervalo">Selecione o intervalo de tempo:</label>
            <select id="intervalo" onchange="carregarGraficoFluxo()">
              <option value="semanal">Últimos 7 dias</option>
              <option value="mensal" selected>Últimos 30 dias</option>
              <option value="bimestral">Últimos 2 meses</option>
              <option value="trimestral">Últimos 3 meses</option>
              <option value="semestral">Últimos 6 meses</option>
              <option value="anual">Últimos 12 meses</option>
            </select>
          </div>
          <canvas id="graficoFluxo" style="height: 400px;"></canvas>
        </div>
        <div class="container_main">
          <div class="container_header">
            <h1>Alunos Matriculados</h1>
          </div>
          <div class="matriculados_main">
            <canvas id="alunosMatriculados"></canvas>
          </div>
        </div>
        <div class="container_main">
          <div class="container_header">
            <h1>Faixa Etária dos Alunos</h1>
          </div>
          <div class="faixa_main">
            <canvas id="faixaEtaria"></canvas>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
  <script src="../js/gerente/fluxo_diario.js"></script>
  <script src="../js/gerente/faixa_etaria.js"></script>
  <script src="../js/gerente/alunos_matriculados.js"></script>
</body>

</html>