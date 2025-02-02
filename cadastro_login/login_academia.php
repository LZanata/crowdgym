<?php
include '../php/conexao.php';

// Inicializa as variáveis de mensagem de erro
$erroLogin = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Busca o usuário (gerente ou funcionário) no banco
  $query = "SELECT id, nome, senha, tipo, Academia_id FROM funcionarios WHERE email = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Verifica se o usuário foi encontrado
  if ($row = mysqli_fetch_assoc($result)) {
    // Verifica se a senha está correta
    if (password_verify($senha, $row['senha'])) {
      // Inicia a sessão e salva os dados do usuário
      session_start();
      $_SESSION['usuario_id'] = $row['id'];
      $_SESSION['usuario_nome'] = $row['nome'];
      $_SESSION['usuario_tipo'] = $row['tipo']; // Define se é gerente ou funcionário
      $_SESSION['Academia_id'] = $row['Academia_id'];

      // Redireciona com base no tipo de usuário
      if ($row['tipo'] === 'gerente') {
        header("Location: http://localhost/Projeto_CrowdGym/gerente/menu_inicial.php");
      } else if ($row['tipo'] === 'funcionario') {
        header("Location: http://localhost/Projeto_CrowdGym/funcionario/menu_inicial.php");
      }
      exit();
    } else {
      $erroLogin = "Senha incorreta. Tente novamente.";
    }
  } else {
    $erroLogin = "Email não encontrado. Tente novamente.";
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
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/cadastro_login/login_academia.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="../js/cadastro_login/ocultar_mensagem.js"></script>
  <title>Login academia</title>
</head>
<!--Parte do Login, obs: quando o usuário fizer login, ele será redirecionado para a página de acordo com a conta dele(funcionário ou de gerente)-->

<body onload="ocultarMensagem()">
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
            <div class="button">
              <a href="cadastro_academia.php">Assinar Crowd Gym</a>
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