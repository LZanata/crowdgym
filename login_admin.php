<?php
include 'php/conexao.php';

// Inicializa a variável de mensagem de erro
$erroLogin = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Obtém os dados do formulário
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Consulta para verificar o administrador no banco de dados usando consulta preparada
  $sql = "SELECT * FROM administrador WHERE email = ? AND senha = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param('ss', $email, $senha);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verifica se há correspondência
  if ($result->num_rows > 0) {
    // Redireciona para a página do administrador
    header("Location: http://localhost/Projeto_CrowdGym/admin_menu_academia.php");
    exit();
  } else {
    // Falha no login, define a mensagem de erro
    $erroLogin = "Email ou senha incorretos. Tente novamente.";
  }

  // Fecha o statement
  $stmt->close();
}

// Fecha a conexão
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/cadastro_login/login_aluno.css">
  <title>Login aluno</title>
</head>

<body>
  <main>
    <div class="container">
      <div class="form">
        <form
          action="php/cadastro_login/login_admin.php"
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
                id="email" />
            </div>
            <div class="input-box">
              <label for="senha">Senha*</label>
              <input
                type="password"
                name="senha"
                placeholder="Digite a senha" maxlength="15"
                id="senha" required />
            </div>
            <div>
              <div class="esqueci-group">
                <div class="esqueci">
                  <a href="recuperar_senha.html">Esqueci minha senha</a>
                </div>
                <div class="error">
                  <!-- Exibe a mensagem de erro, se existir -->
                  <?php if (!empty($erroLogin)): ?>
                    <p id="mensagemErro" style="color: red;"><?php echo $erroLogin; ?></p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="button-group">
                <div class="button">
                  <input type="submit" value="Acessar conta" />
                </div>
              </div>
        </form>
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