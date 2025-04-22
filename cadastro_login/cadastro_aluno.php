<?php
include '../php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cpf = $_POST['cpf'];
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $confirma_senha = $_POST['confirma_senha'];
  $data_nascimento = $_POST['data_nascimento'];
  $genero = $_POST['genero'];

  // Verifica se as senhas coincidem
  if ($senha !== $confirma_senha) {
    echo "Erro: As senhas não coincidem. Tente novamente.";
    exit; // Interrompe a execução se as senhas não coincidirem
  }

  // Hash da senha
  $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

  // Inserir os dados no banco de dados
  $query = "INSERT INTO aluno (cpf, nome, email, senha, genero, data_nascimento) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'ssssss', $cpf, $nome, $email, $senha_hash, $genero, $data_nascimento);

  if (mysqli_stmt_execute($stmt)) {
    echo "Usuário cadastrado com sucesso!";
    // Redirecionar para outra página
    header("Location: http://localhost/Projeto_CrowdGym/cadastro_login/login_aluno.php");
    exit();
  } else {
    echo "Erro ao cadastrar o usuário: " . mysqli_error($conn);
  }

  // Fecha o statement
  mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro Aluno</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/cadastro_login/cadastro_aluno.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="../js/cadastro_login/validar_senha.js"></script>
  <script src="../js/aluno/validarsenha.js"></script>
</head>

<body>
  <main>
    <div class="back-button">
      <a href="login_aluno.php"><i class="bi bi-arrow-left-circle"></i></a>
    </div>
    <div class="conteiner">
      <div class="form">
        <form action="" onsubmit="validarSenha()" method="POST">
          <div class="form-header">
            <div class="title">
              <h1>Crowd Gym</h1>
            </div>
          </div>
          <div class="form-subheader">
            <div class="subtitle">
              <h2>Cadastro de conta do aluno</h2>
            </div>
            <div class="subtitle-main">
              <p>Digite os seus dados para realizar o cadastro</p>
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
                type="email"
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
              <label for="data_nascimento">Data de Nascimento*</label>
              <input type="date" id="data_nascimento" name="data_nascimento" required>
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
          </div>
          <div class="gender-inputs">
            <div class="gender-title">
              <h6>Gênero*</h6>
            </div>

            <div class="gender-group">
              <div class="gender-input">
                <input type="radio" name="genero" id="genero" value="feminino" required>
                <label for="genero">Feminino</label>
              </div>

              <div class="gender-input">
                <input type="radio" name="genero" id="genero" value="masculino" required>
                <label for="genero">Masculino</label>
              </div>

              <div class="gender-input">
                <input type="radio" name="genero" id="genero" value="outro" required>
                <label for="genero">Outro</label>
              </div>
            </div>
          </div>

          <div class="register-button">
            <input type="submit" value="Cadastrar Conta">
          </div>
        </form>
      </div>
    </div>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>