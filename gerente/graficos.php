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
      <!-- Gráfico Distribuição de Planos -->
      <div class="container_main">
        <div class="container_header">
          <h1>Distribuição de Planos</h1>
        </div>
        <div class="container_content">
          <label for="intervaloDistribuicaoPlanos">Selecione o intervalo de tempo:</label>
          <select id="intervaloDistribuicaoPlanos" onchange="carregarDistribuicaoPlanos()">
            <option value="7">Últimos 7 dias</option>
            <option value="30" selected>Últimos 30 dias</option>
            <option value="365">Últimos 365 dias</option>
          </select>
          <canvas id="graficoDistribuicaoPlanos"></canvas>
        </div>
      </div>
      <!-- Gráfico de Receita Mensal por Planos -->
      <div class="container_main">
        <div class="container_header">
          <h1>Receita Mensal por Planos</h1>
        </div>
        <div class="container_content">
          <canvas id="graficoReceitaMensal"></canvas>
        </div>
      </div>
      <!--Gráficos de Alunos Ativos vs Inativos -->
      <div class="container_main">
        <div class="container_header">
          <h1>Alunos Ativos vs. Inativos</h1>
        </div>
        <div class="pizza_content">
          <label for="intervaloAlunosAtivos">Selecione o intervalo de tempo:</label>
          <select id="intervaloAlunosAtivos" onchange="carregarAlunosAtivosInativos()">
            <option value="7">Últimos 7 dias</option>
            <option value="30" selected>Últimos 30 dias</option>
            <option value="365">Últimos 365 dias</option>
          </select>
          <canvas id="graficoAlunosAtivosInativos"></canvas>
        </div>
      </div>
      <!-- Gráfico de Fluxo de Receita Mensal -->
      <div class="container_main">
        <div class="container_header">
          <h1>Fluxo de Receita Mensal</h1>
        </div>
        <div class="container_content">
          <canvas id="graficoFluxoReceitaMensal"></canvas>
        </div>
      </div>
      <!-- Gráfico de Fluxo por Dia da Semana -->
      <div class="container_main">
        <div class="container_header">
          <h1>Fluxo por Dia da Semana</h1>
        </div>
        <div class="container_content">
          <canvas id="graficoFluxoPorDiaSemana"></canvas>
        </div>
      </div>
      <!-- Gráfico de faixa etária -->
      <div class="container_main">
        <div class="container_header">
          <h1>Faixa Etária dos Alunos</h1>
        </div>
        <div class="pizza_content">
          <canvas id="graficoFaixaEtaria"></canvas>
        </div>
      </div>
    </div>
  </main>

  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
  <script src="../js/graficos/quantidade_alunos.js"></script>
  <script src="../js/graficos/fluxo_por_hora.js"></script>
  <script src="../js/graficos/alunos_matriculados.js"></script>
  <script src="../js/graficos/taxa_renovacao.js"></script>
  <script src="../js/graficos/distribuicao_plano.js"></script>
  <script src="../js/graficos/receita_mensal.js"></script>
  <script src="../js/graficos/alunos_ativos_inativos.js"></script>
  <script src="../js/graficos/fluxo_receita_mensal.js"></script>
  <script src="../js/graficos/fluxo_por_dia_semana.js"></script>
  <script src="../js/graficos/faixa_etaria.js"></script>
</body>

</html>