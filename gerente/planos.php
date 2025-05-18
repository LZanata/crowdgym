<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Planos e Serviços</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/gerente/plano.css">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="../js/gerente/ocultar_plano_cadastrado.js"></script>
  <script src="../js/gerente/remover_plano.js"></script>
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
              include '../php/conexao.php';

              // Verifique se o ID da academia está definido na sessão
              if (!isset($_SESSION['Academia_id']) || !isset($_SESSION['usuario_tipo'])) {
                echo "Acesso não autorizado. Por favor, faça o login novamente.";
                exit();
              }

              // Verifica se o usuário autenticado é um gerente ou funcionário
              if ($_SESSION['usuario_tipo'] !== 'gerente') {
                echo "Acesso restrito a gerentes.";
                exit();
              }

              // Obtém o ID da academia associada ao gerente autenticado
              $Academia_id = $_SESSION['Academia_id'];

              // Verifica se o termo de pesquisa foi fornecido
              $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conn, $_GET['pesquisa']) : '';

              // Consulta para buscar os planos com base no Academia_id e no termo de pesquisa
              $query = "SELECT id, nome, descricao, valor, duracao, tipo FROM planos WHERE Academia_id = ?";
              if (!empty($pesquisa)) {
                $query .= " AND (nome LIKE ?)";
              }

              // Prepara e executa a consulta
              $stmt = $conn->prepare($query);
              if (!empty($pesquisa)) {
                $likePesquisa = '%' . $pesquisa . '%';
                $stmt->bind_param("is", $Academia_id, $likePesquisa);
              } else {
                $stmt->bind_param("i", $Academia_id);
              }
              $stmt->execute();
              $result = $stmt->get_result();

              // Verifica se encontrou resultados
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<tr>
            <td class="nome_plano">' . htmlspecialchars($row['nome']) . '</td>
            <td>
                <a href="planos_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                <a href="planos_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                <a href="#" onclick="confirmarRemocao(' . $row['id'] . ')" id="remove">Remover</a>
            </td>
        </tr>';
                }
              } else {
                echo '<tr><td class="nenhum_plano" colspan="6">Nenhum plano encontrado.</td></tr>';
              }
              ?>

              <!-- Mensagem após o sucesso do cadastro -->
              <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
                <div class="mensagem-sucesso">Plano cadastrado com sucesso!</div>
              <?php endif; ?>

              <!-- Mensagem após a remoção -->
              <?php
              if (isset($_GET['removido'])) {
                if ($_GET['removido'] == 1) {
                  echo '<div class="mensagem-sucesso">Plano removido com sucesso!</div>';
                } else {
                  echo '<div class="mensagem-erro">Erro ao remover o plano.</div>';
                }
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>

      <div class="form">
        <form action="../php/gerente/processa_plano.php" method="POST">
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
              <input type="number" id="valor" name="valor" placeholder="Digite o valor do plano" step="0.01" required>
            </div>
            <div class="input-box">
              <label for="duracao">Duração (dias):</label>
              <input type="number" id="duracao" name="duracao" placeholder="Digite a duração do plano" required>
            </div>
            <div class="input-box">
              <label for="tipo">Tipo de Plano:</label>
              <select id="tipo" name="tipo" required>
                <option value="">Selecione um tipo</option>
                <option value="principal">Plano Principal</option>
                <option value="adicional">Serviço Adicional</option>
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
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>