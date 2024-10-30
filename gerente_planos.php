<?php include 'php/cadastro_login/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Planos</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/gerente/plano.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
  <header>
    <nav>
      <!--Menu para alterar as opções de tela-->
      <div class="list">
        <ul>
          <li class="dropdown">
            <a href="#"><i class="bi bi-list"></i></a>

            <div class="dropdown-list">
              <a href="gerente_menu_inicial.php">Menu Inicial</a>
              <a href="gerente_planos.php">Planos e Assinaturas</a>
              <a href="gerente_graficos.php">Gráficos</a>
              <a href="gerente_func.php">Funcionários</a>
              <a href="gerente_aluno.php">Alunos</a>
              <a href="gerente_sobre_nos.php">Sobre Nós</a>
              <a href="gerente_suporte.php">Ajuda e Suporte</a>
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
              <a href="#">Perfil</a>
              <a href="#">Endereço</a>
              <a href="#">Tema</a>
              <a href="#">Sair</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <main>
    <!--Quando clicar devera ter uma opção para adicionar, editar ou remover planos de matricula da academia para os úsuarios alunos poderem assinar-->
    <div class="container">
      <div class="userlist">
        <div class="userlist-header">
          <div class="userlist-title">
            <h1>Planos Cadastrados</h1>
          </div>
          <div class="search-form">
            <form method="GET" action="">
              <input type="text" name="pesquisa" placeholder="Digite o nome do plano"
                value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>" />
              <button type="submit">Pesquisar</button>
            </form>
          </div>
        </div>
        <div class="userlist-table">
          <table>
            <tbody>
              <!-- Preenchendo com os dados do Plano vindo do banco de dados -->
              <?php
              include 'php/conexao.php';

              // Obtém o ID do gerente autenticado
              $gerente_id = $_SESSION['usuario_id'];

              // Verifica se o termo de pesquisa foi fornecido
              $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conexao, $_GET['pesquisa']) : '';

              // Consulta para buscar os planos com base no gerente autenticado e no termo de pesquisa
              $query = "SELECT nome, descricao, valor, duracao, tipo FROM planos WHERE Gerente_id = ?";
              if (!empty($pesquisa)) {
                $query .= " AND (nome LIKE ?)";
              }

              // Prepara e executa a consulta
              $stmt = $conexao->prepare($query);
              if (!empty($pesquisa)) {
                $likePesquisa = '%' . $pesquisa . '%';
                $stmt->bind_param("is", $gerente_id, $likePesquisa);
              } else {
                $stmt->bind_param("i", $gerente_id);
              }
              $stmt->execute();
              $result = $stmt->get_result();

              // Verifica se encontrou resultados
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<tr>
                              <td class="nome_plano">' . htmlspecialchars($row['nome']) . '</td>
                              <td>' . htmlspecialchars($row['descricao']) . '</td>
                              <td>' . htmlspecialchars(number_format($row['valor'], 2, ',', '.')) . '</td>
                              <td>' . htmlspecialchars($row['duracao']) . ' dias</td>
                              <td>' . htmlspecialchars($row['tipo']) . '</td>
                              <td>
                                  <a href="gerente_detalhes_planos.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                                  <a href="gerente_editar_planos.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                                  <a href="#" onclick="confirmarRemocao(' . $row['id'] . ')" id="remove">Remover</a>
                              </td>
                          </tr>';
                }
              } else {
                echo '<tr><td colspan="5">Nenhum plano encontrado.</td></tr>';
              }
              ?>

              <!--Mensagem após a remoção-->
              <?php
              if (isset($_GET['removido']) && $_GET['removido'] == 1) {
                echo '<div id="mensagem-sucesso">Plano removido com sucesso!</div>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="form">
        <form action="php/gerente/processa_plano.php" method="POST">
          <div class="form-header">
            <div class="title">
              <h1>Cadastro de Plano</h1>
            </div>
          </div>
          <div class="input-group">
            <div class="input-box">
              <label for="nome">Nome*</label>
              <input
                type="text"
                name="nome"
                placeholder="Digite o nome"
                id="nome" maxlength="100"
                required />
            </div>
            <div class="input-box">
              <label for="descricao">Descrição*</label>
              <textarea id="descricao" name="descricao" rows="4" placeholder="Digite a descrição do plano" required></textarea>
            </div>
            <div class="input-box">
              <label for="valor">Valor (R$):*</label>
              <input type="number" id="preco" name="preco" placeholder="Digite o valor do plano" step="0.01" required>
            </div>
            <div class="input-box">
              <label for="duracao">Duração (dias):</label>
              <input type="number" id="duracao" name="duracao" placeholder="Digite a duração do plano" required>
            </div>
            <div class="input-box">
              <label for="tipo">Tipo de Plano:</label>
              <select id="tipo" name="tipo" required>
                <option value="">Selecione um tipo</option>
                <option value="principal">Principal</option>
                <option value="adicional">Adicional</option>
              </select>
            </div>
          </div>

          <div class="register-button">
            <input type="submit" value="Cadastrar Plano">
          </div>
        </form>
      </div>
    </div>
    </div>
  </main>
  <footer>
    <div id="footer_copyright">
      &#169
      2024 CROWD GYM FROM EASY SYSTEM LTDA
    </div>
  </footer>
</body>

</html>