<?php
require_once '../php/cadastro_login/check_login_aluno.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Minhas Academias</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/aluno/minhas_academias.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
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
  <?php include '../partials/header_aluno.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <?php
    require_once '../php/conexao.php';

    $aluno_id = $_SESSION['aluno_id']; // ID do aluno logado

    // Consulta para verificar as academias onde o aluno possui assinatura
    $query = $conn->prepare("
    SELECT a.id AS academia_id, a.nome AS nome_academia, ass.status, ass.data_fim, ass.Planos_id AS plano_id
    FROM assinatura ass
    JOIN planos p ON ass.Planos_id = p.id
    JOIN academia a ON p.Academia_id = a.id
    WHERE ass.Aluno_id = ? AND ass.status = 'ativo' AND ass.data_fim >= CURDATE()
    ");
    $query->bind_param("i", $aluno_id);
    $query->execute();
    $result = $query->get_result();

    // Verifica se o aluno possui academias registradas
    if ($result->num_rows > 0): ?>
      <h2>Minhas Academias</h2>
      <ul>
        <?php while ($row = $result->fetch_assoc()): 
          // Consulta para obter o fluxo ao vivo de alunos na academia
          $fluxoQuery = $conn->prepare("
          SELECT COUNT(*) AS total_treinando
          FROM entrada_saida
          WHERE Academia_id = ? AND data_saida IS NULL
          ");
          $fluxoQuery->bind_param("i", $row['academia_id']);
          $fluxoQuery->execute();
          $fluxoResult = $fluxoQuery->get_result();
          $fluxoData = $fluxoResult->fetch_assoc();
          $totalTreinando = $fluxoData['total_treinando'];
        ?>
          <div class="academia">
            <h3><?php echo htmlspecialchars($row['nome_academia']); ?></h3>
            <p>Status: <?php echo htmlspecialchars($row['status']); ?></p>
            <p>Data de término: <?php echo htmlspecialchars($row['data_fim']); ?></p>
            <p>Alunos treinando agora: <strong><?php echo $totalTreinando; ?></strong></p>
            <?php if ($row['status'] === 'ativo'): ?>
              <form action="../php/aluno/cancelar_assinatura.php" method="post">
                <input type="hidden" name="plano_id" value="<?php echo htmlspecialchars($row['plano_id']); ?>">
                <button type="submit" onclick="return confirm('Tem certeza que deseja cancelar esta assinatura?')">Cancelar Assinatura</button>
              </form>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
          <div class="alert alert-success">
            Assinatura cancelada com sucesso!
          </div>
        <?php elseif (isset($_GET['error'])): ?>
          <div class="alert alert-danger">
            Erro ao cancelar assinatura. Tente novamente.
          </div>
        <?php endif; ?>
      </ul>
    <?php else: ?>
      <h2>Nenhuma Academia Registrada</h2>
      <p>Você ainda não possui assinaturas de academias no momento.</p>
      <a href="buscar_academias.php">Clique aqui para buscar uma academia</a>
    <?php endif; ?>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>
