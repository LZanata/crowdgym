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
</head>

<body>
  <!--Aqui é parte do menu incial, assim que o funcionario logar-->
  <?php include '../partials/header_funcionario.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <!--Aqui é onde vai ficar a parte do Menu Inicial-->
    <h1>Fluxo ao Vivo</h1>
    <p>Alunos treinando agora: <strong id="contadorFluxo"><?= htmlspecialchars($alunosTreinando) ?></strong></p>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>