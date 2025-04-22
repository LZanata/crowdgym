<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>cadastrar academia</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="../css/cadastro_login/cadastro_academia.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-button.css">
  <a id="robbu-whatsapp-button" target="_blank" href="https://api.whatsapp.com/send?phone=0">
    <div class="rwb-tooltip">Fale conosco</div>
    <img src="https://cdn.positus.global/production/resources/robbu/whatsapp-button/whatsapp-icon.svg">
  </a>
  <script src="../js/admin/atualizarcidade.js"></script>
  <script src="../js/cadastro_login/formatotelefone.js"></script>
  <script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js">
  </script>
  <script type="text/javascript">
    (function() {
      emailjs.init({
        publicKey: "WVz7dwQpMd2PZrG4Y",
      });
    })();
  </script>
  <script src="../js/cadastro_login/enviar_email.js"></script>
</head>

<body>
  <main>
    <div class="back-button">
      <a href="login_academia.php"><i class="bi bi-arrow-left-circle"></i></a>
    </div>
    <div class="conteiner">
      <div class="form-academia">
        <form onsubmit="sendEmail(); return false;">
          <div class="form-header">
            <div class="title-main">
              <h1>Crowd Gym</h1>
            </div>
            <div class="title-form">
              <h2>Preencha o formulário para entrarmos em contato</h2>
            </div>
          </div>
          <div class="input-group">
            <div class="input-box">
              <label for="nomeAcademia">Nome da Academia*</label>
              <input
                type="text"
                name="nomeAcademia"
                placeholder="Digite o nome"
                id="nomeAcademia" maxlength="100"
                required />
            </div>
            <div class="input-box">
              <label for="nomeGerente">Nome do(a) Gerente*</label>
              <input
                type="text"
                name="nomeGerente"
                placeholder="Digite o nome"
                id="nomeGerente" maxlength="100"
                required />
            </div>

            <div class="input-box">
              <label for="telefoneAcademia">Telefone da Academia*</label>
              <input type="tel" name="telefoneAcademia" placeholder="(00) 00000-0000" id="telefoneAcademia" pattern="\(\d{2}\)\s\d{4,5}-\d{4}"
                oninput="formatTel(this)" required />
            </div>

            <div class="input-box">
              <label for="telefoneGerente">Telefone do(a) Gerente*</label>
              <input type="tel" name="telefoneGerente" placeholder="(00) 00000-0000" id="telefoneGerente" pattern="\(\d{2}\)\s\d{4,5}-\d{4}"
                oninput="formatTel(this)" required />
            </div>


            <div class="input-box">
              <label for="email">E-mail do(a) Gerente*</label>
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
              <select id="cidade" name="cidade" required>
                <option value="">Selecione uma cidade</option>
              </select>
            </div>
            <div class="input-box">
              <label for="bairro">Bairro*</label>
              <input
                type="text"
                name="bairro"
                placeholder="Digite o nome do bairro"
                id="bairro" maxlength="100" required />
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
                placeholder="Digite o numero" maxlength="10"
                id="numero" required />
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
              <label for="abertura">Horário de Abertura*</label>
              <input
                type="time"
                id="abertura"
                name="abertura" required />
            </div>
            <div class="input-box">
              <label for="fechamento">Horário de Fechamento*</label>
              <input
                type="time"
                id="fechamento"
                name="fechamento" required />
            </div>
          </div>
          <div class="days-inputs">
            <div class="days-title">
              <h6>Dias de Funcionamento*</h6>
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
            <input type="submit" id="enviarEmail" value="Enviar Formulário">
          </div>
        </form>
      </div>
    </div>
    </div>
    </div>
  </main>
  <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>