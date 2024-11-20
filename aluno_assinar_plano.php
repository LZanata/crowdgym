<?php
require_once 'php/cadastro_login/check_login_aluno.php';
require_once 'php/conexao.php';

$conexao = mysqli_connect("localhost", "root", "", "crowdgym");

$plano_id = isset($_GET['plano_id']) ? (int) $_GET['plano_id'] : 0;
$aluno_id = $_SESSION['aluno_id'];

// Verifica se o plano existe
$queryPlano = $conexao->prepare("SELECT * FROM planos WHERE id = ?");
$queryPlano->bind_param("i", $plano_id);
$queryPlano->execute();
$resultPlano = $queryPlano->get_result();
$plano = $resultPlano->fetch_assoc();

if (!$plano) {
    echo "Plano não encontrado!";
    exit;
}

// Verifica se o aluno já assinou este plano
$queryAssinatura = $conexao->prepare("SELECT * FROM assinatura WHERE Planos_id = ? AND Aluno_id = ? AND status = 'ativo'");
$queryAssinatura->bind_param("ii", $plano_id, $aluno_id);
$queryAssinatura->execute();
$resultAssinatura = $queryAssinatura->get_result();

if ($resultAssinatura->num_rows > 0) {
    echo "Você já assinou este plano.";
    exit;
}

// Insere uma nova assinatura
$data_inicio = date('Y-m-d');
$data_fim = date('Y-m-d', strtotime("+{$plano['duracao']} days"));
$valor_pago = $plano['valor'];
$status = 'ativo';

$queryInserir = $conexao->prepare("INSERT INTO assinatura (status, valor_pago, data_inicio, data_fim, Planos_id, Aluno_id) VALUES (?, ?, ?, ?, ?, ?)");
$queryInserir->bind_param("sdssii", $status, $valor_pago, $data_inicio, $data_fim, $plano_id, $aluno_id);

if ($queryInserir->execute()) {
    echo "Plano assinado com sucesso!";
} else {
    echo "Erro ao assinar o plano.";
}

$queryPlano->close();
$queryAssinatura->close();
$queryInserir->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Planos - <?php echo htmlspecialchars($academia['nome']); ?></title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/aluno/plano_academia.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <header>
        <!--Quando clicar nesta opção tem que aparecer as academias que ele está matriculado no sistema e quando clicar na academia deverá mostrar os dados de quantas pessoas estão treinando e os planos assinados nesta academia. -->
        <nav>
            <!--Menu para alterar as opções de tela-->
            <div class="list">
                <ul>
                    <li class="dropdown">
                        <a href="#"><i class="bi bi-list"></i></a>

                        <div class="dropdown-list">
                            <a href="aluno_menu_inicial.php">Menu Inicial</a>
                            <a href="aluno_minhas_academias.php">Minhas Academias</a>
                            <a href="aluno_buscar_academias.php">Buscar Academias</a>
                            <a href="aluno_dados_pagamento.php">Dados de Pagamento</a>
                            <a href="aluno_sobre_nos.php">Sobre Nós</a>
                            <a href="aluno_suporte.php">Ajuda e Suporte</a>
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
                            <a href="#">Editar Perfil</a>
                            <a href="#">Alterar Tema</a>
                            <a href="#">Sair da Conta</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
    <a href="aluno_buscar_academias.php">Voltar</a>   
    </main>
</body>

</html>