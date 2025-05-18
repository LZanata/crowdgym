<?php
include '../php/cadastro_login/check_login_funcionario.php';
include '../php/conexao.php'; // Arquivo de conexão com o banco de dados

$academia_id = $_SESSION['Academia_id']; // ID da academia do funcionário logado

// Consultar os registros de entrada e saída dos alunos
$query = $conn->prepare("
    SELECT es.id, es.data_entrada, es.data_saida, a.nome AS nome_aluno, a.id AS aluno_id
    FROM entrada_saida es
    INNER JOIN aluno a ON es.Aluno_id = a.id
    WHERE es.Academia_id = ?
    ORDER BY es.data_entrada DESC
");
$query->bind_param("i", $academia_id);
$query->execute();
$resultado = $query->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Entradas e Saídas</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/funcionario/entrada_saida.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
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
    <!--Aqui o funcionário poderá ver o registro dos alunos que entraram e sairam da academia-->
    <?php include '../partials/header_funcionario.php'; ?> <!-- Inclui o cabeçalho -->
    <main>
        <h1>Registro de Entrada e Saída de Alunos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>Data/Hora de Entrada</th>
                    <th>Data/Hora de Saída</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($linha = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['nome_aluno']) ?></td>
                        <td><?= htmlspecialchars($linha['data_entrada']) ?></td>
                        <td><?= $linha['data_saida'] ? htmlspecialchars($linha['data_saida']) : 'Ainda na academia' ?></td>
                        <td>
                            <form method="GET" action="aluno_detalhes.php" style="display:inline;">
                                <input type="hidden" name="aluno_id" value="<?= $linha['aluno_id'] ?>">
                                <button type="submit">Ver Detalhes</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>