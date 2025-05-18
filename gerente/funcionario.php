<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gerente Funcionário</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/gerente/funcionario.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="../js/gerente/validar_senha.js"></script>
  <script src="../js/gerente/formatocpf.js"></script>
  <script src="../js/gerente/confirmar_exclusao.js"></script>
  <script src="../js/gerente/ocultar_mensagem.js"></script>
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
  <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
  <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->

  <main>
    <div class="container">
      <div class="userlist">
        <div class="userlist-header">
          <div class="userlist-title">
            <h1>Funcionários Cadastrados</h1>
          </div>
          <div class="search-form">
            <form method="GET" action="">
              <input type="text" name="pesquisa" placeholder="Digite o nome do funcionário"
                value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>" />
              <button type="submit">Pesquisar</button>
            </form>
          </div>
        </div>
        <div class="userlist-table">
          <table>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include '../php/conexao.php';

              $Academia_id = $_SESSION['Academia_id']; // Obtém o ID da academia do gerente autenticado

              // Verifica se o termo de pesquisa foi fornecido
              $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conn, $_GET['pesquisa']) : '';

              // Consulta para buscar apenas os funcionários da academia associada
              $query = "SELECT id, nome, email FROM funcionarios WHERE Academia_id = ? AND tipo = 'funcionario'";
              if (!empty($pesquisa)) {
                $query .= " AND (nome LIKE ? OR email LIKE ?)";
              }

              // Prepara e executa a consulta
              $stmt = $conn->prepare($query);
              if (!empty($pesquisa)) {
                $likePesquisa = '%' . $pesquisa . '%';
                $stmt->bind_param("iss", $Academia_id, $likePesquisa, $likePesquisa);
              } else {
                $stmt->bind_param("i", $Academia_id);
              }
              $stmt->execute();
              $result = $stmt->get_result();


              // Verifica se encontrou resultados
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>
                              <td class="nome_func">' . htmlspecialchars($row['nome']) . '</td>
                              <td>
                                  <a href="funcionario_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                                  <a href="funcionario_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                                  <a href="#" onclick="confirmarRemocao(' . $row['id'] . ')" id="remove">Remover</a>
                              </td>
                          </tr>';
                }
              } else {
                echo '<tr><td colspan="2">Nenhum funcionário encontrado.</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="form">
        <form action="../php/gerente/processa_cadastro_funcionario.php" method="POST">
          <div class="form-header">
            <div class="title">
              <h1>Cadastro do Funcionário</h1>
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
              <label for="email">E-mail*</label>
              <input
                type="text"
                name="email"
                placeholder="Digite o email" maxlength="255"
                id="email" />
            </div>
            <div class="input-box">
              <label for="cpf">CPF*</label>
              <input
                type="text" id="cpf" name="cpf" placeholder="000.000.000-00"
                pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                oninput="formatCPF(this)"
                maxlength="14"
                required>
            </div>
            <div class="input-box">
              <label for="cargo">Cargo*</label>
              <input type="text" name="cargo" placeholder="Digite o cargo" id="cargo" required />
            </div>
            <div class="input-box">
              <label for="senha">Senha*</label>
              <input
                type="password"
                name="senha"
                placeholder="Digite a senha" maxlength="15"
                id="senha" required />
            </div>
            <div class="input-box">
              <label for="confirma_senha">Confirme a Senha*</label>
              <input
                type="password"
                name="confirma_senha"
                placeholder="Digite a senha novamente" maxlength="15"
                id="confirma_senha" required />
            </div>
            <div class="input-box">
              <label for="data_contrat">Data de Contratação - opcional</label>
              <input type="date" id="data_contrat" name="data_contrat" required>
            </div>
            <div class="input-box">
              <label for="tipo">Tipo de Funcionário:</label>
              <select id="tipo" name="tipo" required>
                <option value="">Selecione um tipo</option>
                <option value="gerente">Gerente</option>
                <option value="funcionario">Funcionário</option>
              </select>
            </div>
          </div>
          <div class="gender-inputs">
            <div class="gender-title">
              <h6>Gênero*</h6>
            </div>

            <div class="gender-group">
              <div class="gender-input">
                <input type="radio" name="genero" id="genero_feminino" value="feminino" required>
                <label for="genero_feminino">Feminino</label>
              </div>

              <div class="gender-input">
                <input type="radio" name="genero" id="genero_masculino" value="masculino" required>
                <label for="genero_masculino">Masculino</label>
              </div>

              <div class="gender-input">
                <input type="radio" name="genero" id="genero_outro" value="outro" required>
                <label for="genero_outro">Outro</label>
              </div>
            </div>
          </div>

          <div class="register-button">
            <input type="submit" value="Cadastrar" />
          </div>
        </form>
      </div>
    </div>
  </main>

  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->

  <script>
    // Confirmação de remoção de funcionário
    function confirmarRemocao(id) {
      if (confirm("Tem certeza que deseja remover este funcionário?")) {
        window.location.href = '../php/gerente/remover_func.php?id=' + id;
      }
    }
  </script>

</body>

</html>