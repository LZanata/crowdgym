<?php
include '../php/cadastro_login/check_login_admin.php';
include '../php/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $rua = $_POST['rua'];
  $numero = $_POST['numero'];
  $complemento = $_POST['complemento'];
  $bairro = $_POST['bairro'];
  $cidade = $_POST['cidade'];
  $estado = $_POST['estado'];
  $cep = $_POST['cep'];
  $dia_semana = $_POST['dia_semana'];
  $abertura = $_POST['abertura'];
  $fechamento = $_POST['fechamento'];

  // Inserir os dados no banco de dados
  $query = "INSERT INTO academia (nome, telefone, rua, numero, complemento, bairro, cidade, estado, cep, dia_semana, abertura, fechamento) VALUES ('$nome','$telefone', '$rua', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$dia_semana', '$abertura', '$fechamento')";

  if (mysqli_query($conn, $query)) {
    echo "Usuário cadastrado com sucesso!";
    // Redirecionar para outra página
    header("Location: http://localhost/Projeto_CrowdGym/administrador/cadastro_gerente.php");
    exit();
  } else {
    echo "Erro ao cadastrar o usuário: " . mysqli_error($conn);
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrador Menu</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/admin/menu_academia.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="../js/admin/atualizarcidade.js"></script>
  <script src="../js/admin/formatotelefone.js"></script>
</head>

<body>
  <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
  <?php include '../partials/header_admin.php'; ?> <!-- Inclui o cabeçalho -->
  <main>
    <div class="container">
      <div class="form">
        <form action="" method="POST">
          <div class="form-header">
            <div class="title">
              <h1>Cadastro de Academia</h1>
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
              <label for="telefone">Telefone*</label>
              <input
                type="tel"
                name="telefone"
                placeholder="(00) 00000-0000"
                id="telefone"
                pattern="\(\d{2}\)\s\d{4,5}-\d{4}"
                oninput="formatTel(this)"
                required />
            </div>
            <div class="input-box" id="cep-box">
              <label for="cep">CEP*</label>
              <input type="text" id="cep" name="cep" maxlength="8" placeholder="00000000" required
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
            <div class="input-box">
              <label for="estado">Estado*</label>
              <select id="estado" name="estado" onchange="atualizarCidades()" required>
                <option value="">Selecione um estado</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
              </select>
            </div>
            <div class="input-box">
              <label for="cidade">Cidade*</label>
              <select id="cidade" name="cidade">
                <option value="">Selecione uma cidade</option>
              </select>
            </div>
            <div class="input-box">
              <label for="bairro">Bairro*</label>
              <input
                type="text"
                name="bairro"
                placeholder="Digite o nome do bairro"
                id="bairro" maxlength="100"
                required />
            </div>
            <div class="input-box">
              <label for="rua">Rua*</label>
              <input
                type="text"
                name="rua"
                placeholder="Digite o nome da rua" maxlength="100"
                id="rua" required />
            </div>
            <div class="input-box">
              <label for="numero">Numero*</label>
              <input
                type="number"
                name="numero"
                placeholder="Digite o numero"
                id="numero" maxlength="10"
                required />
            </div>
            <div class="input-box">
              <label for="complemento">Complemento - opcional</label>
              <input
                type="text"
                name="complemento"
                placeholder="Digite o complemento"
                id="complemento" maxlength="255" />
            </div>
            <div class="input-box">
              <label for="abertura">Horário de Abertura - opcional</label>
              <input
                type="time"
                id="abertura"
                name="abertura" required />
            </div>
            <div class="input-box">
              <label for="fechamento">Horário de Fechamento - opcional</label>
              <input
                type="time"
                id="fechamento"
                name="fechamento" required />
            </div>
          </div>
          <div class="days-inputs">
            <div class="days-title">
              <h6>Dias de Funcionamento - opcional</h6>
            </div>

            <div class="days-group">
              <div class="days-input">
                <input
                  type="radio"
                  id="Segunda a Sexta"
                  name="dia_semana"
                  value="Segunda a Sexta" required />
                <label for="Segunda a Sexta">Segunda a Sexta</label>
              </div>

              <div class="days-input">
                <input
                  type="radio"
                  id="Segunda a Sábado"
                  name="dia_semana"
                  value="Segunda a Sábado" required />
                <label for="Segunda a Sábado">Segunda a Sábado</label>
              </div>

              <div class="days-input">
                <input
                  type="radio"
                  id="Todos os dias"
                  name="dia_semana"
                  value="Todos os dias" required />
                <label for="Todos os dias">Todos os dias</label>
              </div>
            </div>
          </div>

          <div class="register-button">
            <input type="submit" value="Cadastrar Academia" />
          </div>
        </form>
      </div>
    </div>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>