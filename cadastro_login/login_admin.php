<?php
session_start(); // Inicia a sessão
include '../php/conexao.php';

// Inicializa a variável de mensagem de erro
$erroLogin = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtém os dados do formulário
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Consulta para buscar o administrador no banco de dados com base no email
  $sql = "SELECT id, senha FROM administrador WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verifica se há correspondência
  if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    // Verifica a senha
    if (password_verify($senha, $usuario['senha'])) {
      // Armazena o ID do administrador na sessão
      $_SESSION['administrador_id'] = $usuario['id'];

      // Redireciona para a página de administração
      header("Location: http://localhost/Projeto_CrowdGym/administrador/cadastro_academia.php");
      exit();
    } else {
      // Falha na autenticação
      $erroLogin = "Email ou senha incorretos. Tente novamente.";
    }
  } else {
    // Nenhum usuário encontrado com o email
    $erroLogin = "Email ou senha incorretos. Tente novamente.";
  }

  // Fecha o statement
  $stmt->close();
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/cadastro_login/login_aluno.css">
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Login aluno</title>
</head>

<body>
  <main>
    <div class="back-button">
      <a href="../index.php"><i class="bi bi-arrow-left-circle"></i></a>
    </div>
    <div class="container">
      <div class="form">
        <form
          action=""
          method="POST"
          class="formLogin">
          <div class="form-header">
            <div class="title">
              <h1>Crowd Gym</h1>
            </div>
          </div>
          <div class="form-subheader">
            <div class="subtitle">
              <h2>Login</h2>
              <p>Digite os dados de acesso no campo abaixo.</p>
            </div>
          </div>
          <div class="input-group">
            <div class="input-box">
              <label for="email">E-mail*</label>
              <input
                type="text"
                name="email"
                placeholder="Digite o email" maxlength="255"
                id="email" required />
            </div>
            <div class="input-box">
              <label for="senha">Senha*</label>
              <input
                type="password"
                name="senha"
                placeholder="Digite a senha" maxlength="15"
                id="senha" required />
            </div>
            <div class="esqueci-group">
              <div class="error">
                <!-- Exibe a mensagem de erro, se existir -->
                <?php if (!empty($erroLogin)): ?>
                  <p id="mensagemErro" style="color: red;"><?php echo $erroLogin; ?></p>
                <?php endif; ?>
              </div>
              <div class="esqueci">
                <a href="recuperar_senha.php">Esqueci minha senha</a>
              </div>
            </div>
          </div>
          <div class="button-group">
            <div class="button">
              <input type="submit" value="Acessar conta" />
            </div>
        </form>
      </div>
    </div>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>