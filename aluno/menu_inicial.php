<?php
require_once '../php/conexao.php';
require_once '../php/cadastro_login/check_login_aluno.php';

$aluno_id = $_SESSION['aluno_id'];

// Consulta para buscar o último treino
$query = $conexao->prepare("
    SELECT DATE_FORMAT(data_entrada, '%a, %d de %b') AS ultimo_treino,
           TIME_FORMAT(data_entrada, '%H:%i') AS horario_entrada,
           TIME_FORMAT(data_saida, '%H:%i') AS horario_saida
    FROM entrada_saida
    WHERE Aluno_id = ?
    ORDER BY data_entrada DESC
    LIMIT 1
");
$query->bind_param("i", $aluno_id);
$query->execute();
$resultado = $query->get_result();
$dados = $resultado->fetch_assoc();

$ultimo_treino = $dados ? $dados['ultimo_treino'] : "Nenhum treino registrado";
$horario_entrada = $dados ? $dados['horario_entrada'] : "--:--";
$horario_saida = $dados ? $dados['horario_saida'] : "--:--";
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
        <canvas id="graficoHorasTreino"></canvas>
      </div>
      <div class="info">
        <div class="last-train">
          <h2>Último Treino Realizado</h2>
          <p><?= htmlspecialchars($ultimo_treino); ?></p>
        </div>
        <div class="time-arrive">
          <h2>Horário de Chegada</h2>
          <p><?= htmlspecialchars($horario_entrada); ?></p>
        </div>
        <div class="time-left">
          <h2>Horário de Saída</h2>
          <p><?= htmlspecialchars($horario_saida); ?></p>
        </div>
      </div>
    </section>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
  <!-- Importando a biblioteca Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Importando a tabela no JavaScript-->
  <script src="../js/aluno/tabela_horas_semanal.js"></script>
</body>

</html>