<?php include 'php/cadastro_login/check_login-funcionarios.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerente Funcionário</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gerente/plano.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="js/gerente/validar_senha.js"></script>
    <script src="js/gerente/formatocpf.js"></script>
    <script src="js/gerente/remover_plano.js"></script>
    <script src="js/gerente/ocultar_mensagem.js"></script>
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
                            <a href="gerente_menu_inicial.php">Menu Inicial</a>
                            <a href="gerente_planos.php">Planos e Serviços</a>
                            <a href="gerente_graficos.php">Gráficos</a>
                            <a href="gerente_func.php">Funcionários</a>
                            <a href="gerente_aluno.php">Alunos</a>
                            <a href="gerente_sobre_nos.php">Sobre Nós</a>
                            <a href="gerente_suporte.php">Ajuda e Suporte</a>
                            <a href="php/cadastro_login/logout.php">Sair</a>
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
                            <a href="#">Endereço</a>
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
                            include 'php/conexao.php';

                            // Verifica se o termo de pesquisa foi fornecido
                            $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conexao, $_GET['pesquisa']) : '';

                            // Consulta para buscar os alunos com base no termo de pesquisa
                            $query = "SELECT id, nome, email, foto FROM aluno";
                            if (!empty($pesquisa)) {
                                $query .= " WHERE (nome LIKE ? OR email LIKE ?)";
                            }

                            // Prepara e executa a consulta
                            $stmt = $conexao->prepare($query);
                            if ($stmt === false) {
                                die("Erro na preparação da consulta: " . $conexao->error);
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
                <a href="gerente_aluno_detalhes.php?id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" id="details">Ver Detalhes</a> 
                <a href="gerente_aluno_editar.php?id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" id="edit">Editar</a> 
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
                $stmt = mysqli_prepare($conexao, $query);
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

                <form action="php/aluno/editar.php" method="post">
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
    <footer>
        <div id="footer_copyright">
            &#169
            2024 CROWD GYM FROM EASY SYSTEM LTDA
        </div>
    </footer>
</body>

</html>