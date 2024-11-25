<?php
require_once 'php/cadastro_login/check_login_aluno.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Minhas Academias</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/aluno/minhas_academias.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
  <header>
    <!--Quando clicar nesta opção tem que aparecer as academias que ele está matriculado no sistema e quando clicar na academia deverá mostrar os dados de quantas pessoas estão treinando e os planos assinados nesta academia. -->
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
    <?php
    require_once 'php/cadastro_login/check_login_aluno.php';
    require_once 'php/conexao.php';

    $aluno_id = $_SESSION['aluno_id']; // ID do aluno logado

    // Consulta para verificar as academias onde o aluno possui assinatura
    $query = $conexao->prepare("
    SELECT a.nome AS nome_academia, ass.status, ass.data_fim, ass.Planos_id AS plano_id
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
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="academia">
            <h3><?php echo htmlspecialchars($row['nome_academia']); ?></h3>
            <p>Status: <?php echo htmlspecialchars($row['status']); ?></p>
            <p>Data de término: <?php echo htmlspecialchars($row['data_fim']); ?></p>
            <?php if ($row['status'] === 'ativo'): ?>
              <form action="cancelar_assinatura.php" method="post">
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
      <a href="aluno_buscar_academias.php">Clique aqui para buscar uma academia</a>
    <?php endif; ?>
  </main>
  <footer>
    <div id="footer_copyright">
      &#169
      2024 CROWD GYM FROM EASY SYSTEM LTDA
    </div>
  </footer>
</body>

</html>