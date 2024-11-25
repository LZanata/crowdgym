<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrador Menu</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/admin/menu_academia.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="js/admin/atualizarcidade.js"></script>
  <script src="js/admin/formatotelefone.js"></script>
  <script src="js/admin/formatocpf.js"></script>
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
              <a href="admin_menu_academia.php">Academia</a>
              <a href="admin_menu_gerente.php">Gerente</a>
              <a href="">Sobre Nós</a>
              <a href="">Ajuda e Suporte</a>
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
      <div class="form">
        <form action="php/admin/cadastro_academia.php" method="POST">
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
              <input
                type="text"
                id="cep"
                name="cep"
                maxlength="9"
                oninput="aplicarMascaraCEP(this)"
                placeholder="00000-000"
                required />
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
  <footer>
    <div id="footer_copyright">
      &#169
      2024 CROWD GYM FROM EASY SYSTEM LTDA
    </div>
  </footer>
</body>

</html>