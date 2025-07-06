<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerente Editar Funcionário</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/gerente/funcionario.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="../js/gerente/validar_senha.js"></script>
    <script src="../js/gerente/formatocpf.js"></script>
    <script src="../js/gerente/confirmar_exclusao.js"></script>
    <script src="../js/gerente/ocultar_mensagem.js"></script>
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6827a6cd36f29c190d216342/1irdh4qa7';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body>
    <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
    <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->

    <main>
        <div class="container">
            <div class="userlist">
                <div class="userlist-header">
                    <div class="userlist-title">
                        <h1>Funcionários Cadastrados</h1>
                    </div>
                    <div class="search-form">
                        <form method="GET" action="">
                            <input type="text" name="pesquisa" placeholder="Digite o nome ou email"
                                value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>" />
                            <button type="submit">Pesquisar</button>
                        </form>
                    </div>
                </div>
                <div class="userlist-table">
                    <table>
                        <tbody>
                            <!-- Preenchendo com os dados do funcionário vindo do banco de dados -->
                            <?php
                            include '../php/conexao.php';

                            $Academia_id = $_SESSION['Academia_id']; // Obtém o ID da academia do gerente autenticado

                            // Verifica se o termo de pesquisa foi fornecido
                            $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conn, $_GET['pesquisa']) : '';

                            // Consulta para buscar apenas os funcionários da academia associada
                            $query = "SELECT id, nome, email FROM funcionarios WHERE Academia_id = ? AND tipo = 'funcionario'";
                            if (!empty($pesquisa)) {
                                $query .= " AND (nome LIKE ? OR email LIKE ?)";
                            }

                            // Prepara e executa a consulta
                            $stmt = $conn->prepare($query);
                            if (!empty($pesquisa)) {
                                $likePesquisa = '%' . $pesquisa . '%';
                                $stmt->bind_param("iss", $Academia_id, $likePesquisa, $likePesquisa);
                            } else {
                                $stmt->bind_param("i", $Academia_id);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();


                            // Verifica se encontrou resultados
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                              <td class="nome_func">' . htmlspecialchars($row['nome']) . '</td>
                              <td>
                                  <a href="funcionario_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                                  <a href="funcionario_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                                  <a href="#" onclick="confirmarRemocao(' . $row['id'] . ')" id="remove">Remover</a>
                              </td>
                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="2">Nenhum funcionário encontrado.</td></tr>';
                            }
                            ?>

                            <!--Mensagem após a remoção-->
                            <?php
                            if (isset($_GET['removido']) && $_GET['removido'] == 1) {
                                echo '<div id="mensagem-sucesso">Funcionário removido com sucesso!</div>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<p>Perfil atualizado com sucesso!</p>";
            }
            ?>
            <?php
            include '../php/conexao.php';

            // Verifica se o ID foi enviado na URL
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consulta para obter os dados do funcionário pelo ID
                $query = "SELECT id, nome, email, cpf, cargo, data_contrat, genero, tipo FROM funcionarios WHERE id = ? AND tipo = 'funcionario'"; // Verifica apenas funcionários
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Verifica se o funcionário foi encontrado
                if ($usuario = mysqli_fetch_assoc($result)) {
                    // Preenche os dados no formulário
                } else {
                    echo "Funcionário não encontrado.";
                    exit;
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "ID do funcionário não fornecido.";
                exit;
            }
            ?>
            <div class="form">
                <div class="form-header">
                    <div class="title">
                        <h1>Editar Funcionário</h1>
                    </div>
                </div>

                <form action="../php/gerente/editar_func.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" placeholder="Digite o nome" id="nome" maxlength="100"
                                value="<?php echo htmlspecialchars($usuario['nome']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="email">Email:</label>
                            <input type="email" name="email" placeholder="Digite o email" maxlength="255" id="email"
                                value="<?php echo htmlspecialchars($usuario['email']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" placeholder="000.000.000-00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                oninput="formatCPF(this)" maxlength="14"
                                value="<?php echo htmlspecialchars($usuario['cpf']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="cargo">Cargo:</label>
                            <input type="text" name="cargo" placeholder="Digite o cargo" id="cargo"
                                value="<?php echo htmlspecialchars($usuario['cargo']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="data_contrat">Data de Contratação:</label>
                            <input type="date" id="data_contrat" name="data_contrat"
                                value="<?php echo htmlspecialchars($usuario['data_contrat']); ?>">
                        </div>
                        <div class="input-box">
                            <label for="tipo">Tipo de Funcionário:</label>
                            <select id="tipo" name="tipo" required>
                                <option value="">Selecione um tipo</option>
                                <option value="gerente">Gerente</option>
                                <option value="funcionario">Funcionário</option>
                            </select>
                        </div>
                    </div>

                    <div class="gender-inputs">
                        <div class="gender-title">
                            <h6>Gênero*</h6>
                        </div>

                        <div class="gender-group">
                            <div class="gender-input">
                                <input type="radio" name="genero" id="genero_feminino" value="feminino"
                                    <?php echo ($usuario['genero'] == 'feminino') ? 'checked' : ''; ?>>
                                <label for="genero_feminino">Feminino</label>
                            </div>

                            <div class="gender-input">
                                <input type="radio" name="genero" id="genero_masculino" value="masculino"
                                    <?php echo ($usuario['genero'] == 'masculino') ? 'checked' : ''; ?>>
                                <label for="genero_masculino">Masculino</label>
                            </div>

                            <div class="gender-input">
                                <input type="radio" name="genero" id="genero_outro" value="outro"
                                    <?php echo ($usuario['genero'] == 'outro') ? 'checked' : ''; ?>>
                                <label for="genero_outro">Outro</label>
                            </div>
                        </div>
                    </div>

                    <div class="register-button">
                        <input type="submit" value="Atualizar Perfil">
                    </div>
                </form>

            </div>

        </div>
    </main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>