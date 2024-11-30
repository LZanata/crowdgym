<?php
include '../php/cadastro_login/check_login_funcionario.php';
include '../php/conexao.php';
include '../php/funcoes/funcoes_fluxo.php';

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <?php include '../partials/header_funcionario.php'; ?> <!-- Inclui o cabeçalho -->
    <main>
        <div class="dashboard">
            <div class="chart-container">
                <h1>Histórico de Fluxo</h1>
                <canvas id="graficoFluxo"></canvas>
            </div>
            <div class="fluxo">
                <h1>Fluxo AO VIVO</h1>
                <p>Alunos treinando agora: <strong id="contadorFluxo"><?= htmlspecialchars($alunosTreinando) ?></strong></p>
            </div>
        </div>
    </main>
    <?php include '../partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/funcionario/historico_fluxo.js"></script>
    <script src="../js/funcionario/atualizar_fluxo.js?v=1.0"></script>
</body>

</html>
