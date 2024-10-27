<?php
include 'php/conexao.php';

// Inicializa as variáveis de mensagem de erro
$erroLogin = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Primeiro, tenta buscar o usuário como gerente
  $query = "SELECT * FROM gerente WHERE email = ?";
  $stmt = mysqli_prepare($conexao, $query);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    // Verifica se a senha está correta para o gerente
    if (password_verify($senha, $row['senha'])) {
      // Inicia a sessão e salva os dados do gerente
      session_start();
      $_SESSION['usuario_id'] = $row['id'];
      $_SESSION['usuario_nome'] = $row['nome'];
      $_SESSION['usuario_tipo'] = 'gerente';

      // Redireciona para a página do gerente
      header("Location: http://localhost/Projeto_CrowdGym/gerente_menu_inicial.php");
      exit();
    } else {
      $erroLogin = "Senha incorreta. Tente novamente.";
    }
  } else {
    // Se não encontrou o gerente, tenta buscar o usuário como funcionário
    $query = "SELECT * FROM funcionario WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      // Verifica se a senha está correta para o funcionário
      if (password_verify($senha, $row['senha'])) {
        // Inicia a sessão e salva os dados do funcionário
        session_start();
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['usuario_nome'] = $row['nome'];
        $_SESSION['usuario_tipo'] = 'funcionario';

        // Redireciona para a página do funcionário
        header("Location: http://localhost/Projeto_CrowdGym/func_menu_inicial.php");
        exit();
      } else {
        $erroLogin = "Senha incorreta. Tente novamente.";
      }
    } else {
      $erroLogin = "Email não encontrado. Tente novamente.";
    }
  }

  // Fecha o statement
  mysqli_stmt_close($stmt);
}

// Fecha a conexão
mysqli_close($conexao);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/cadastro_login/login_academia.css" />
  <script src="js/cadastro_login/ocultar_mensagem.js"></script>
  <title>Login academia</title>
</head>
<!--Parte do Login, obs: quando o usuário fizer login, ele será redirecionado para a página de acordo com a conta dele(funcionário ou de gerente)-->

<body onload="ocultarMensagem()">
  <main>
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
                <a href="recuperar_senha.html">Esqueci minha senha</a>
              </div>
            </div>
            <div class="button-group">
              <div class="button">
                <input type="submit" value="Acessar conta" />
              </div>
              <div class="button">
                <a href="cadastro_academia.html">Assinar Crowd Gym</a>
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