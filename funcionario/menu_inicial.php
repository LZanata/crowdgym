<?php
include '../php/cadastro_login/check_login_funcionario.php';
include '../php/conexao.php';

// Função para contar alunos treinando
function contarAlunosTreinando($academia_id, $conexao)
{
    $query = $conexao->prepare("
        SELECT COUNT(*) AS total
        FROM entrada_saida
        WHERE Academia_id = ? AND data_saida IS NULL
    ");
    $query->bind_param("i", $academia_id);
    $query->execute();
    $resultado = $query->get_result();
    $dados = $resultado->fetch_assoc();

    return $dados['total'];
}

$academia_id = $_SESSION['Academia_id'];
$alunosTreinando = contarAlunosTreinando($academia_id, $conexao);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Funcionário Menu Inicial</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/funcionario/menu_inicial.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <!-- Aqui é parte do menu inicial, assim que o funcionário logar -->
    <?php include '../partials/header_funcionario.php'; ?> <!-- Inclui o cabeçalho -->
    <main>
        <div class="dashboard">
            <div class="chart-container">
                <h1>Histórico de Fluxo</h1>
                <!-- Canvas onde o gráfico será exibido -->
                <canvas id="graficoFluxo"></canvas>
            </div>
            <div class="fluxo">
                <h1>Fluxo AO VIVO</h1>
                <p>Alunos treinando agora: <strong id="contadorFluxo"><?= htmlspecialchars($alunosTreinando) ?></strong></p>
            </div>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
    <!-- Inclui o script JS para atualizar o gráfico e fluxo -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/funcionario/historico_fluxo.js"></script>
    <script src="../js/funcionario/atualizar_fluxo.js?v=1.0"></script>
</body>

</html>
