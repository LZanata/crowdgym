<?php
include '../php/cadastro_login/check_login_admin.php';
include '../php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cpf = $_POST['cpf'];
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $senha = $_POST['senha'];
  $confirma_senha = $_POST['confirma_senha'];
  $Academia_id = $_POST['Academia_id'];
  $tipo = 'gerente'; // Define o tipo como 'gerente'

  // Verifica se as senhas coincidem
  if ($senha !== $confirma_senha) {
    echo "Erro: As senhas não coincidem. Tente novamente.";
    exit; // Interrompe a execução se as senhas não coincidirem
  }

  // Hash da senha
  $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

  // Inserir os dados no banco de dados
  $query = "INSERT INTO funcionarios (cpf, nome, email, telefone, senha, tipo, Academia_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'ssssssi', $cpf, $nome, $email, $telefone, $senha_hash, $tipo, $Academia_id);

  if (mysqli_stmt_execute($stmt)) {
    echo "Gerente cadastrado com sucesso!";
    // Redirecionar para outra página
    header("Location: http://localhost/Projeto_CrowdGym/administrador/cadastro_academia.php");
    exit();
  } else {
    echo "Erro ao cadastrar o gerente: " . mysqli_error($conn);
  }

  // Fecha o statement
  mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrador Menu Gerente</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/admin/menu_gerente.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="../js/admin/validarsenha.js"></script>
  <script src="../js/admin/atualizarcidade.js"></script>
  <script src="../js/admin/formatotelefone.js"></script>
</head>

<body>
  <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
  <?php include '../partials/header_admin.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <div class="container">
      <div class="form">
        <form action="" onsubmit="validarSenha()" method="POST">
          <div class="form-header">
            <div class="title">
              <h1>Cadastro de Gerente</h1>
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
                id="email" required />
            </div>
            <div class="input-box">
              <label for="cpf">CPF*</label>
              <input
                type="text" id="cpf" name="cpf" placeholder="00000000000"
                maxlength="11"
                required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            <div class="input-box">
              <label for="telefone">Telefone*</label>
              <input type="tel" name="telefone" placeholder="(00) 00000-0000" id="telefone" pattern="\(\d{2}\)\s\d{4,5}-\d{4}"
                oninput="formatTel(this)" required />
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
              <label for="Academia_id">ID da Academia*</label>
              <input
                type="text"
                name="Academia_id"
                placeholder="Digite o ID"
                id="Academia_id" required />
            </div>
          </div>

          <div class="register-button">
            <input type="submit" value="Cadastrar Gerente">
          </div>
        </form>
      </div>
    </div>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>