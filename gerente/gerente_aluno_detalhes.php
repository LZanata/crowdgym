<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerente Funcionário</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/gerente/funcionario.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="../js/gerente/confirmar_exclusao.js"></script>
    <script src="../js/gerente/ocultar_mensagem.js"></script>
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
                            include '../php/conexao.php';

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
            include 'php/conexao.php';

            // Verifica se o ID do aluno foi enviado na URL
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consulta para obter os dados do aluno pelo ID
                $query = "SELECT nome, cpf, email, genero, data_nascimento, foto FROM aluno WHERE id = ?";
                $stmt = mysqli_prepare($conexao, $query);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Verifica se o aluno foi encontrado
                if ($row = mysqli_fetch_assoc($result)) {
                    echo '
        <div class="form">
            <div class="form-header">
                <div class="title">
                    <h1>Detalhes do Aluno</h1> 
                </div>
            </div>';
                    echo '<p class="details">Nome: ' . htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p class="details">CPF: ' . htmlspecialchars($row['cpf'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p class="details">Email: ' . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p class="details">Gênero: ' . htmlspecialchars($row['genero'], ENT_QUOTES, 'UTF-8') . '</p>';
                    echo '<p class="details">Data de Nascimento: ' . htmlspecialchars($row['data_nascimento'], ENT_QUOTES, 'UTF-8') . '</p>';

                    // Exibe a foto do aluno, se existir
                    $fotoPath = !empty($row['foto']) ? htmlspecialchars($row['foto'], ENT_QUOTES, 'UTF-8') : 'php/uploads/imagem_padrao.jpg';
                    echo '<p class="details">Foto: <img src="' . $fotoPath . '" alt="Foto do aluno" width="200" /></p>';
                } else {
                    echo "Aluno não encontrado.";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "ID do aluno não fornecido.";
            }
            ?>
        </div>

    </main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>