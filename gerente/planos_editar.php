<?php
include '../php/cadastro_login/check_login_gerente.php';
include '../php/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crowd Gym - Gerente Editar Planos</title>
    <meta name="description" content="Gerenciamento de planos e funcionários no Crowd Gym">
    <meta name="keywords" content="academia, planos, gerenciamento, Crowd Gym">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/gerente/plano.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
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
                            // Verifica se o ID da academia está definido na sessão
                            if (!isset($_SESSION['Academia_id'])) {
                                echo "Acesso não autorizado. Por favor, faça o login novamente.";
                                exit();
                            }

                            // Obtém o ID da academia associada ao gerente autenticado
                            $Academia_id = $_SESSION['Academia_id'];

                            // Verifica se o termo de pesquisa foi fornecido
                            $pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

                            // Consulta para buscar os planos com base no Academia_id e no termo de pesquisa
                            $query = "SELECT id, nome, descricao, valor, duracao, tipo FROM planos WHERE Academia_id = ?";
                            if (!empty($pesquisa)) {
                                $query .= " AND nome LIKE ?";
                            }

                            // Prepara e executa a consulta
                            $stmt = $conn->prepare($query);
                            if (!empty($pesquisa)) {
                                $likePesquisa = '%' . $pesquisa . '%';
                                $stmt->bind_param("is", $Academia_id, $likePesquisa);
                            } else {
                                $stmt->bind_param("i", $Academia_id);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Verifica se encontrou resultados
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
            if (isset($_GET['success']) && $_GET['success'] == 1) {
                echo "<p>Perfil atualizado com sucesso!</p>";
            }
            ?>

            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                // Consulta para obter os dados do plano pelo ID
                $query = "SELECT id, nome, descricao, valor, duracao, tipo FROM planos WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($plano = $result->fetch_assoc()) {
                    // Exibe o formulário com os dados do plano
                } else {
                    echo "Plano não encontrado.";
                    exit;
                }
            } else {
                echo "ID do plano não fornecido.";
                exit;
            }
            ?>

            <div class="form">
                <div class="form-header">
                    <div class="title">
                        <h1>Editar Plano</h1>
                    </div>
                </div>

                <form action="../php/gerente/editar_plano.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($plano['id']); ?>">

                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Nome do Plano:</label>
                            <input type="text" name="nome" placeholder="Digite o nome do plano" id="nome" maxlength="100"
                                value="<?php echo htmlspecialchars($plano['nome']); ?>" required>
                        </div>

                        <div class="input-box">
                            <label for="descricao">Descrição:</label>
                            <textarea name="descricao" placeholder="Digite a descrição do plano" id="descricao" maxlength="255" required><?php echo htmlspecialchars($plano['descricao']); ?></textarea>
                        </div>

                        <div class="input-box">
                            <label for="valor">Valor (R$):</label>
                            <input type="number" name="valor" placeholder="Digite o valor" id="valor" step="0.01" min="0"
                                value="<?php echo htmlspecialchars($plano['valor']); ?>" required>
                        </div>

                        <div class="input-box">
                            <label for="duracao">Duração (dias):</label>
                            <input type="number" name="duracao" placeholder="Duração do plano em dias" id="duracao" min="1"
                                value="<?php echo htmlspecialchars($plano['duracao']); ?>" required>
                        </div>

                        <div class="input-box">
                            <label for="tipo">Tipo:</label>
                            <select id="tipo" name="tipo" required>
                                <option value="">Selecione um tipo</option>
                                <option value="principal" <?php if ($plano['tipo'] == 'principal') echo 'selected'; ?>>Plano Principal</option>
                                <option value="adicional" <?php if ($plano['tipo'] == 'adicional') echo 'selected'; ?>>Serviço Adicional</option>
                            </select>
                        </div>
                    </div>

                    <div class="register-button">
                        <input type="submit" value="Salvar Alterações">
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>