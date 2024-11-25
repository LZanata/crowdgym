<?php include 'php/cadastro_login/check_login_gerente.php'; ?>

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
  <?php include 'partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->
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
  <?php include 'partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>