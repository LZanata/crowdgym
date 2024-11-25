<?php
require_once 'php/conexao.php';
require_once 'php/cadastro_login/check_login.php';

// Obtém o ID da academia a partir da sessão do gerente
$academia_id = $_SESSION['Academia_id'];

// Inicializa a variável $result como null
$result = null;

// Captura o termo de pesquisa, se existir
$pesquisa = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : '';

try {
    // Base da consulta SQL
    $sql = "
        SELECT 
            aluno.id AS aluno_id,
            aluno.nome AS aluno_nome,
            aluno.email AS aluno_email,
            assinatura.id AS assinatura_id,
            assinatura.data_inicio,
            assinatura.data_fim,
            assinatura.status,
            planos.nome AS plano_nome,
            planos.valor AS plano_valor,
            planos.duracao AS plano_duracao
        FROM assinatura
        INNER JOIN aluno ON assinatura.Aluno_id = aluno.id
        INNER JOIN planos ON assinatura.Planos_id = planos.id
        INNER JOIN academia ON planos.Academia_id = academia.id
        WHERE academia.id = ? AND assinatura.status = 'ativo'";

    // Adiciona condição para pesquisa, se aplicável
    if (!empty($pesquisa)) {
        $sql .= " AND aluno.nome LIKE ?";
    }

    $query = $conexao->prepare($sql);

    // Define os parâmetros para a consulta
    if (!empty($pesquisa)) {
        $pesquisa = "%$pesquisa%";
        $query->bind_param("is", $academia_id, $pesquisa);
    } else {
        $query->bind_param("i", $academia_id);
    }

    $query->execute();
    $result = $query->get_result();
} catch (Exception $e) {
    echo "Erro ao executar a consulta: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerente Aluno</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gerente/aluno.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="js/gerente/formatocpf.js"></script>
</head>

<body>
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
        <!--Nesta tela o gerente poderá ver as informações dos alunos e fazer alterações-->
        <div class="container">
            <div class="userlist">
                <div class="userlist-header">
                    <div class="userlist-title">
                        <h1>Alunos da Academia</h1>
                    </div>
                    <div class="search-form">
                        <form method="GET" action="">
                            <input type="text" name="pesquisa" placeholder="Digite o nome do aluno"
                                value="<?php echo isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''; ?>" />
                            <button type="submit">Pesquisar</button>
                        </form>
                    </div>
                </div>
                <div class="userlist-table">
                    <table>
                        <tbody>

                            <?php if ($result->num_rows > 0): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Nome do Aluno</th>
                                            <th>Email</th>
                                            <th>Plano</th>
                                            <th>Valor</th>
                                            <th>Data de Início</th>
                                            <th>Data de Término</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['aluno_nome']); ?></td>
                                                <td><?php echo htmlspecialchars($row['aluno_email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['plano_nome']); ?></td>
                                                <td>R$ <?php echo number_format($row['plano_valor'], 2, ',', '.'); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($row['data_inicio'])); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($row['data_fim'])); ?></td>
                                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Nenhum aluno matriculado na sua academia no momento.</p>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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