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
  <script src="../js/admin/formatocpf.js"></script>
</head>

<body>
  <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
  <?php include '../partials/header_admin.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <div class="container">
      <div class="form">
        <form action="../php/admin/cadastro_gerente.php" onsubmit="validarSenha()" method="POST">
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
                type="text" id="cpf" name="cpf" placeholder="000.000.000-00"
                pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                oninput="formatCPF(this)"
                maxlength="14"
                required>
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