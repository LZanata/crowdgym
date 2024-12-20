<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Inicial Gerente</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/gerente/menu_inicial.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- Importando a biblioteca Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <section>
      <!-- Quantidade de Alunos Presentes -->
      <div class="card">
        <i class="bi bi-people-fill"></i>
        <h3>Alunos Presentes</h3>
        <p id="quantidade-alunos">Carregando...</p>
      </div>

      <!-- Gráfico de Fluxo Diário -->
      <div class="chart-options">
        <label for="intervalo">Intervalo:</label>
        <select id="intervalo">
          <option value="semana">Última Semana</option>
          <option value="mes">Último Mês</option>
        </select>
      </div>
      <div class="chart-container">
        <canvas id="graficoFluxo" aria-label="Gráfico de Fluxo Diário de Alunos"></canvas>
      </div>

      <!-- Últimas Matrículas Realizadas -->
      <div class="conteudo_lista">
        <div class="lista_alunos">
          <div class="lista_header">
            <h1>Últimas Matrículas Realizadas</h1>
          </div>
          <div class="lista_principal">
            <?php
            include '../php/conexao.php';
            $query = "SELECT nome, data_inicio FROM assinatura INNER JOIN aluno ON assinatura.Aluno_id = aluno.id ORDER BY data_inicio DESC LIMIT 3";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
              echo "<div class='aluno-item'>";
              echo "<p><strong>Nome:</strong> {$row['nome']}</p>";
              echo "<p><strong>Data de Matrícula:</strong> " . date('d/m/Y', strtotime($row['data_inicio'])) . "</p>";
              echo "</div>";
            }
            ?>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
  <!-- Campo oculto para o ID da academia -->
  <!-- Campo oculto para o ID da academia -->
  <input type="hidden" id="academiaId" value="<?= isset($_SESSION['Academia_id']) ? htmlspecialchars($_SESSION['Academia_id']) : '' ?>">

  <script src="../js/graficos/fluxo_diario.js"></script>
</body>

</html>