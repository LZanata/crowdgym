<?php include 'php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crowd Gym - Gerente Detalhes dos Planos</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gerente/plano.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="js/gerente/remover_plano.js"></script>
    <script src="js/gerente/ocultar_mensagem.js"></script>
</head>

<body>
    <header>
        <nav>
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
            <div class="logo">
                <h1>Crowd Gym</h1>
            </div>
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
                            <input type="text" name="pesquisa" placeholder="Digite o nome do plano"
                                value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>" />
                            <button type="submit">Pesquisar</button>
                        </form>
                    </div>
                </div>
                <div class="userlist-table">
                    <table>
                        <tbody>
                            <?php
                            include 'php/conexao.php';

                            if (!isset($_SESSION['Academia_id'])) {
                                echo "Acesso não autorizado. Por favor, faça o login novamente.";
                                exit();
                            }

                            $Academia_id = $_SESSION['Academia_id'];
                            $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conexao, $_GET['pesquisa']) : '';

                            $query = "SELECT id, nome, descricao, valor, duracao, tipo FROM planos WHERE Academia_id = ?";
                            if (!empty($pesquisa)) {
                                $query .= " AND nome LIKE ?";
                            }

                            $stmt = $conexao->prepare($query);
                            if (!empty($pesquisa)) {
                                $likePesquisa = '%' . $pesquisa . '%';
                                $stmt->bind_param("is", $Academia_id, $likePesquisa);
                            } else {
                                $stmt->bind_param("i", $Academia_id);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

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
                                echo '<tr><td class="nenhum_plano" colspan="6">Nenhum plano encontrado.</td></tr>';
                            }
                            ?>

                            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
                                echo '<div class="mensagem-sucesso">Plano cadastrado com sucesso!</div>';
                            } ?>

                            <?php
                            if (isset($_GET['removido']) && $_GET['removido'] == 1) {
                                echo '<div id="mensagem-sucesso">Plano removido com sucesso!</div>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $query = "SELECT nome, descricao, valor, duracao, tipo FROM planos WHERE id = ?";
                $stmt = $conexao->prepare($query);
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
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

                $stmt->close();
            } else {
                echo "ID do plano não fornecido.";
            }
            ?>
        </div>
    </main>

    <footer>
        <div id="footer_copyright">
            &#169 2024 CROWD GYM FROM EASY SYSTEM LTDA
        </div>
    </footer>
</body>

</html>
