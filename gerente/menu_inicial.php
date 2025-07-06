<?php
session_start();
//echo "Academia_id na sessão: " . ($_SESSION['Academia_id'] ?? 'Não definido');

include '../php/cadastro_login/check_login_gerente.php';
include '../php/conexao.php';

// Verifique se a variável de sessão 'Academia_id' está definida
if (!isset($_SESSION['Academia_id'])) {
  // Redirecionar ou exibir uma mensagem de erro, se não estiver definido
  die("Erro: Academia não associada à sua conta.");
}

// Consulta para obter o número de alunos treinando ao vivo
$queryFluxo = $conn->prepare("SELECT COUNT(*) AS total FROM entrada_saida WHERE Academia_id = ? AND data_saida IS NULL");
$queryFluxo->bind_param("i", $_SESSION['Academia_id']);
$queryFluxo->execute();
$resultadoFluxo = $queryFluxo->get_result();
$rowFluxo = $resultadoFluxo->fetch_assoc();
$alunosTreinando = $rowFluxo['total'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu Inicial Gerente</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/gerente/menu_inicial.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <section>
      <!-- Quantidade de Alunos Presentes -->
      <div class="card">
        <i class="bi bi-people-fill"></i>
        <h3>Quantidade de Alunos Presentes:</h3>
        <p><strong id="contadorFluxo"><?= htmlspecialchars($alunosTreinando) ?></strong></p>
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
            $query = "SELECT aluno.nome, assinatura.data_inicio 
            FROM assinatura
            INNER JOIN aluno ON assinatura.Aluno_id = aluno.id
            INNER JOIN planos ON assinatura.Planos_id = planos.id
            WHERE planos.Academia_id = ? 
            ORDER BY assinatura.data_inicio DESC 
            LIMIT 3";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION['Academia_id']);
            $stmt->execute();
            $result = $stmt->get_result();
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
  <input type="hidden" id="academiaId" value="<?= isset($_SESSION['Academia_id']) ? htmlspecialchars($_SESSION['Academia_id']) : '' ?>">
  <script src="../js/fluxo/atualizar_fluxo.js"></script>
  <script src="../js/graficos/fluxo_diario.js"></script>
</body>

</html>