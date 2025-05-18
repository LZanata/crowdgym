<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerente Funcionário</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/gerente/plano.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="../js/gerente/validar_senha.js"></script>
    <script src="../js/gerente/formatocpf.js"></script>
    <script src="../js/gerente/remover_plano.js"></script>
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
                        <h1>Alunos Cadastrados</h1>
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

                            // Verifica se o termo de pesquisa foi fornecido
                            $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conn, $_GET['pesquisa']) : '';

                            // Consulta para buscar os alunos com base no termo de pesquisa
                            $query = "SELECT id, nome, email, foto FROM aluno";
                            if (!empty($pesquisa)) {
                                $query .= " WHERE (nome LIKE ? OR email LIKE ?)";
                            }

                            // Prepara e executa a consulta
                            $stmt = $conn->prepare($query);
                            if ($stmt === false) {
                                die("Erro na preparação da consulta: " . $conn->error);
                            }

                            if (!empty($pesquisa)) {
                                $likePesquisa = '%' . $pesquisa . '%';
                                $stmt->bind_param("ss", $likePesquisa, $likePesquisa);
                            }

                            if (!$stmt->execute()) {
                                echo "Erro ao executar a consulta: " . $stmt->error;
                                exit;
                            }

                            $result = $stmt->get_result();

                            // Verifica se encontrou resultados
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
            <td class="nome_func">' . htmlspecialchars($row['nome'] ?? '', ENT_QUOTES, 'UTF-8') . '</td>
            <td><img src="' . htmlspecialchars($row['foto'] ?? 'php/uploads/', ENT_QUOTES, 'UTF-8') . '" alt="Foto do aluno" width="200" /></td>
            <td>
                <a href="aluno_detalhes.php?id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" id="details">Ver Detalhes</a> 
                <a href="aluno_editar.php?id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" id="edit">Editar</a> 
                <a href="#" onclick="confirmarRemocao(' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ')" id="remove">Remover</a>
            </td>
        </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">Nenhum aluno encontrado.</td></tr>';
                            }
                            ?>

                            <!--Mensagem após a remoção-->
                            <?php
                            if (isset($_GET['removido']) && $_GET['removido'] == 1) {
                                echo '<div id="mensagem-sucesso">Aluno removido com sucesso!</div>';
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
            // Verifica se o ID foi enviado na URL
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consulta para obter os dados do aluno pelo ID
                $query = "SELECT id, nome, email, cpf, data_nascimento, genero FROM aluno WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Verifica se o aluno foi encontrado
                if ($aluno = mysqli_fetch_assoc($result)) {
                    // Exibe o formulário de edição com os dados do aluno
                } else {
                    echo "Aluno não encontrado.";
                    exit;
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "ID do aluno não fornecido.";
                exit;
            }
            ?>

            <div class="form">
                <div class="form-header">
                    <div class="title">
                        <h1>Editar Aluno</h1>
                    </div>
                </div>

                <form action="../php/aluno/editar.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($aluno['id']); ?>">
                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" placeholder="Digite o nome" id="nome" maxlength="100"
                                value="<?php echo htmlspecialchars($aluno['nome']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="email">Email:</label>
                            <input type="email" name="email" placeholder="Digite o email" maxlength="255" id="email"
                                value="<?php echo htmlspecialchars($aluno['email']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="cpf">CPF:</label>
                            <input type="text" name="cpf" placeholder="000.000.000-00" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                                oninput="formatCPF(this)" maxlength="14"
                                value="<?php echo htmlspecialchars($aluno['cpf']); ?>">
                        </div>

                        <div class="input-box">
                            <label for="data_nascimento">Data de Nascimento:</label>
                            <input type="date" id="data_nascimento" name="data_nascimento"
                                value="<?php echo htmlspecialchars($aluno['data_nascimento']); ?>">
                        </div>
                    </div>

                    <div class="gender-inputs">
                        <div class="gender-title">
                            <h6>Gênero*</h6>
                        </div>

                        <div class="gender-group">
                            <div class="gender-input">
                                <input type="radio" name="genero" id="genero_feminino" value="feminino"
                                    <?php echo ($aluno['genero'] == 'feminino') ? 'checked' : ''; ?>>
                                <label for="genero_feminino">Feminino</label>
                            </div>

                            <div class="gender-input">
                                <input type="radio" name="genero" id="genero_masculino" value="masculino"
                                    <?php echo ($aluno['genero'] == 'masculino') ? 'checked' : ''; ?>>
                                <label for="genero_masculino">Masculino</label>
                            </div>

                            <div class="gender-input">
                                <input type="radio" name="genero" id="genero_outro" value="outro"
                                    <?php echo ($aluno['genero'] == 'outro') ? 'checked' : ''; ?>>
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