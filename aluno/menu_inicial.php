<?php
require_once '../php/cadastro_login/check_login_aluno.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Inicial Aluno</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/aluno/menu_inicial.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
  <!--Menu para alterar as opções de tela-->
  <?php include '../partials/header_aluno.php'; ?> <!-- Inclui o cabeçalho -->

  <main>
    <!--Aqui terá um gráfico semanal de quantas horas o aluno treinou durante todos os dias da semana- o ultimo dia e horario que o aluno foi e saiu da academia -->
    <section>
      <div class="chart-container">
        <canvas id="meuGrafico"></canvas>
      </div>
      <!-- Importando a biblioteca Chart.js -->
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <!-- Importando a tabela no JavaScript-->
      <script src="../js/aluno/tabela_horas_semanal.js"></script>
      <div class="info">
        <div class="last-train">
          <h2>Ultimo Treino Realizado</h2>
          <p>sex. 19 de set.</p>
        </div>
        <div class="time-arrive">
          <h2>Horário de Chegada</h2>
          <p>05:29</p>
        </div>
        <div class="time-left">
          <h2>Horário de Saída</h2>
          <p>07:40</p>
        </div>
      </div>
    </section>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>