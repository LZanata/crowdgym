<?php
require_once 'php/cadastro_login/check_login_aluno.php';
require_once 'php/conexao.php';

// Busca academias com base no nome ou cidade
$filtro = isset($_GET['filtro']) ? "%" . $_GET['filtro'] . "%" : "%";
$query = $conexao->prepare("SELECT * FROM academia WHERE nome LIKE ? OR cidade LIKE ?");
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
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/aluno/buscar_academia.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
  <header>
    <!-- Quando clicar tem que aparecer uma barra de pesquisa e as academias conectadas com o Crowd Gym mais próximas da localização do usuário abaixo da barra de pesquisa e quando clicar na academia deverá mostrar os planos de matricula da academia -->
    <nav>
      <!--Menu para alterar as opções de tela-->
      <div class="list">
        <ul>
          <li class="dropdown">
            <a href="#"><i class="bi bi-list"></i></a>

            <div class="dropdown-list">
              <a href="aluno_menu_inicial.php">Menu Inicial</a>
              <a href="aluno_minhas_academias.php">Minhas Academias</a>
              <a href="aluno_buscar_academias.php">Buscar Academias</a>
              <a href="aluno_dados_pagamento.php">Dados de Pagamento</a>
              <a href="aluno_sobre_nos.php">Sobre Nós</a>
              <a href="aluno_suporte.php">Ajuda e Suporte</a>
              <a href="php/cadastro_login/logout.php">Sair</a>
            </div>
          </li>
        </ul>
      </div>
      <!--Logo do Crowd Gym(quando passar o mouse por cima, o logo devera ficar laranja)-->
      <div class="logo">
        <h1>Crowd Gym</h1>
      </div>
      <!--Opção para alterar as configurações de usuário-->
      <div class="user">
        <ul>
          <li class="user-icon">
            <a href=""><i class="bi bi-person-circle"></i></a>

            <div class="dropdown-icon">
              <a href="#">Editar Perfil</a>
              <a href="#">Alterar Tema</a>
              <a href="#">Sair da Conta</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
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
          <a href="aluno_plano_academia.php?academia_id=<?php echo $academia['id']; ?>">Ver Planos</a>
        </li>
      <?php endwhile; ?>
    </ul>
  </main>
  <footer>
    <div id="footer_copyright">
      &#169
      2024 CROWD GYM FROM EASY SYSTEM LTDA
    </div>
  </footer>
</body>

</html>