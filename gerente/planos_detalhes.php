<?php include '../php/cadastro_login/check_login_gerente.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crowd Gym - Gerente Detalhes dos Planos</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/gerente/plano.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
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
    <?php include '../partials/header_gerente.php'; ?> <!-- Inclui o cabeçalho -->

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
                            include '../php/conexao.php';

                            if (!isset($_SESSION['Academia_id'])) {
                                echo "Acesso não autorizado. Por favor, faça o login novamente.";
                                exit();
                            }

                            $Academia_id = $_SESSION['Academia_id'];
                            $pesquisa = isset($_GET['pesquisa']) ? mysqli_real_escape_string($conn, $_GET['pesquisa']) : '';

                            $query = "SELECT id, nome, descricao, valor, duracao, tipo FROM planos WHERE Academia_id = ?";
                            if (!empty($pesquisa)) {
                                $query .= " AND nome LIKE ?";
                            }

                            $stmt = $conn->prepare($query);
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
                                                <a href="planos_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                                                <a href="planos_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
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
                $stmt = $conn->prepare($query);
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

    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>