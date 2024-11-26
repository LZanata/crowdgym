<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/cadastro_login/tela_inicio.css" />
    <title>Tela inicio</title>
  </head>

  <body>
    <main>
        <div class="header">
          <div class="admin">
            <a href="cadastro_login/login_admin.php"><span> Área de ADM</span></a>
          </div>
          <div class="crowd">
            <h1>Crowd Gym</h1>
          </div>
        </div>
        <div class="botoes">
            <div class="bentrar1">
            <a href="cadastro_login/login_aluno.php"
              ><span> Área do aluno</span></a>
            </div>
            <div class="bentrar2">
            <a href="cadastro_login/login_academia.php"
              ><span>Área da academia</span></a>
            </div>
        </div>
    </main>
    <?php include 'partials/footer.php'; ?> <!-- Inclui o rodapé -->
  </body>
</html>
