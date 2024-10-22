<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gerente Funcionário</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/gerente/funcionario.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="js/gerente/validar_senha.js"></script>
  <script src="js/gerente/formatocpf.js"></script>
</head>

<body>
  <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
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
              <a href="tela_inicio.html">Sair</a>
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
    <div class="container">
      <div class="userlist">
        <div class="userlist-header">
          <div class="userlist-title">
            <h1>Funcionários Cadastrados</h1>
          </div>
        </div>
        <div class="userlist-table">
          <table>
            <tbody>
              <!-- Preenchendo com os dados do funcionário vindo do banco de dados -->
              <?php
              include 'php/gerente/conexao.php';
              $query = "SELECT id, nome, email FROM funcionario";
              $result = mysqli_query($conexao, $query);

              while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>
                          <td class="nome_func">' . $row['nome'] . '</td>
                          <td>
                              <a href="gerente_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                              <a href="gerente_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                              <a href="remover.php?id=' . $row['id'] . '" id="remove">Remover</a>
                          </td>
                        </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="form">
        <form action="php/gerente/processa_cadastro.php" method="POST">
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
              <label for="Gerente_id">Id do Gerente*</label>
              <input
                type="text"
                name="Gerente_id"
                placeholder="Digite o ID"
                id="Gerente_id" required />
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
            <input type="submit" value="Cadastrar">
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