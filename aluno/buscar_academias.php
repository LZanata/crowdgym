<?php
require_once '../php/cadastro_login/check_login_aluno.php';
require_once '../php/conexao.php';

// Busca academias com base no nome ou cidade
$filtro = isset($_GET['filtro']) ? "%" . $_GET['filtro'] . "%" : "%";
$query = $conn->prepare("SELECT * FROM academia WHERE nome LIKE ? OR cidade LIKE ?");
$query->bind_param("ss", $filtro, $filtro);
$query->execute();
$resultado = $query->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buscar Academias</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/aluno/buscar_academia.css">
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
  <!-- Quando clicar tem que aparecer uma barra de pesquisa e as academias conectadas com o Crowd Gym mais próximas da localização do usuário abaixo da barra de pesquisa e quando clicar na academia deverá mostrar os planos de matricula da academia -->
  <?php include '../partials/header_aluno.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <h1>Pesquisar Academias</h1>
    <form method="get" action="">
      <input type="text" name="filtro" placeholder="Nome ou Cidade">
      <button type="submit">Pesquisar</button>
    </form>
    <ul>
      <?php while ($academia = $resultado->fetch_assoc()): ?>
        <li>
          <h3><?php echo htmlspecialchars($academia['nome']); ?></h3>
          <p>Telefone: <?php echo htmlspecialchars($academia['telefone']); ?></p>
          <p>Funcionamento: <?php echo htmlspecialchars($academia['dia_semana'] . " das " . $academia['abertura'] . " às " . $academia['fechamento']); ?></p>
          <p>Endereço: <?php echo htmlspecialchars($academia['rua'] . ", " . $academia['numero'] . " - " . $academia['bairro'] . ", " . $academia['cidade'] . " - " . $academia['estado']); ?></p>
          <a href="plano_academia.php?academia_id=<?php echo $academia['id']; ?>">Ver Planos</a>
        </li>
      <?php endwhile; ?>
    </ul>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>