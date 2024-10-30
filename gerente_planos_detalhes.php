<?php include 'php/cadastro_login/check_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerente Funcionário</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gerente/funcionario.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="js/gerente/confirmar_exclusao.js"></script>
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
                            <a href="gerente_planos.php">Planos e Assinaturas</a>
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
                        <h1>Planos Cadastrados</h1>
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

                            // Obtém o ID do gerente autenticado
                            $gerente_id = $_SESSION['usuario_id'];

                            // Verifica se o termo de pesquisa foi fornecido
                            $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conexao, $_GET['pesquisa']) : '';

                            // Consulta para buscar os planos com base no gerente autenticado e no termo de pesquisa, incluindo a coluna 'id'
                            $query = "SELECT id, nome, descricao, valor, duracao, tipo FROM planos WHERE Gerente_id = ?";
                            if (!empty($pesquisa)) {
                                $query .= " AND (nome LIKE ?)";
                            }

                            // Prepara e executa a consulta
                            $stmt = $conexao->prepare($query);
                            if (!empty($pesquisa)) {
                                $likePesquisa = '%' . $pesquisa . '%';
                                $stmt->bind_param("is", $gerente_id, $likePesquisa);
                            } else {
                                $stmt->bind_param("i", $gerente_id);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Verifica se encontrou resultados
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>
                  <td class="nome_plano">' . htmlspecialchars($row['nome']) . '</td>
                  <td>
                      <a href="gerente_planos_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                      <a href="gerente_planos_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                      <a href="#" onclick="confirmarRemocao(' . $row['id'] . ')" id="remove">Remover</a>
                  </td>
              </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">Nenhum plano encontrado.</td></tr>';
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
            include 'php/conexao.php';

            // Verifica se o ID foi enviado na URL
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consulta para obter os dados do plano pelo ID
                $query = "SELECT nome, descricao, valor, duracao, tipo FROM planos WHERE id = ?";
                $stmt = mysqli_prepare($conexao, $query);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Verifica se o plano foi encontrado
                if ($row = mysqli_fetch_assoc($result)) {
                    echo '
        <div class="form">
            <div class="form-header">
                <div class="title">
                    <h1>Detalhes do Plano</h1>
                </div>
            </div>
            <p class="details">Nome: ' . htmlspecialchars($row['nome']) . '</p>
            <p class="details">Descrição: ' . htmlspecialchars($row['descricao']) . '</p>
            <p class="details">Valor: R$ ' . htmlspecialchars(number_format($row['valor'], 2, ',', '.')) . '</p>
            <p class="details">Duração: ' . htmlspecialchars($row['duracao']) . ' dias</p>
            <p class="details">Tipo: ' . htmlspecialchars($row['tipo']) . '</p>
        </div>';
                } else {
                    echo "Plano não encontrado.";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "ID do plano não fornecido.";
            }
            ?>

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