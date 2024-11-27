<?php
include '../php/cadastro_login/check_login_funcionario.php';
include '../php/conexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['Academia_id'])) {
  header("Location: login.php");
  exit;
}

// Função para contar alunos treinando
function contarAlunosTreinando($academia_id, $conexao)
{
  $query = $conexao->prepare("
        SELECT COUNT(*) AS total
        FROM entrada_saida
        WHERE Academia_id = ? AND data_saida IS NULL
    ");
  $query->bind_param("i", $academia_id);
  $query->execute();
  $resultado = $query->get_result();
  $dados = $resultado->fetch_assoc();

  return $dados['total'];
}

$academia_id = $_SESSION['Academia_id'];
$alunosTreinando = contarAlunosTreinando($academia_id, $conexao);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Funcionário Menu Inicial</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/funcionario/menu_inicial.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="../js/funcionario/atualizar_fluxo.js?v=1.0"></script>
  <!-- Importando a biblioteca Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <!--Aqui é parte do menu incial, assim que o funcionario logar-->
  <?php include '../partials/header_funcionario.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <div class="dashboard">
      <div class="chart-container">
        <canvas id="quantidadeAlunos"></canvas>
      </div>
      <div class="card">
        <h1>Fluxo AO VIVO</h1>
        <p>Alunos treinando agora: <strong id="contadorFluxo"><?= htmlspecialchars($alunosTreinando) ?></strong></p>
      </div>
      <div class="card">
        <h3>Histórico de Fluxo</h3>
        <canvas id="graficoFluxo"></canvas>
      </div>
      <div class="card">
        <h3>Capacidade</h3>
        <p id="capacidadeMaxima"></p>
      </div>
    </div>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
  <!-- Importando a tabela no JavaScript-->
  <script src="../js/funcionario/quantidade_alunos.js"></script>
</body>

</html>