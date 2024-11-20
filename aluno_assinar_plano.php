<?php
require_once 'php/conexao.php';
require_once 'php/cadastro_login/check_login_aluno.php';

// Obtém o plano_id da URL
$plano_id = isset($_GET['plano_id']) ? (int)$_GET['plano_id'] : 0;

if (!$plano_id) {
    echo "Erro: ID do plano não informado.";
    exit;
}

// Conexão ao banco
$conexao = mysqli_connect("localhost", "root", "", "crowdgym");

if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Busca os detalhes do plano
$queryPlano = $conexao->prepare("SELECT * FROM planos WHERE id = ?");
if (!$queryPlano) {
    echo "Erro na preparação da consulta: " . $conexao->error;
    exit;
}
$queryPlano->bind_param("i", $plano_id);
$queryPlano->execute();
$resultPlano = $queryPlano->get_result();
$plano = $resultPlano->fetch_assoc();

if (!$plano) {
    echo "Plano não encontrado.";
    exit;
}

// Fecha a consulta
$queryPlano->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Assinar Plano - <?php echo htmlspecialchars($plano['nome']); ?></title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/aluno/plano_academia.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <header>
        <!-- Menu de navegação -->
        <nav>
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
            <div class="logo">
                <h1>Crowd Gym</h1>
            </div>
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
        <h2>Plano: <?php echo htmlspecialchars($plano['nome']); ?></h2>
        <p>Descrição: <?php echo htmlspecialchars($plano['descricao']); ?></p>
        <p>Valor: R$ <?php echo number_format($plano['valor'], 2, ',', '.'); ?></p>
        <p>Duração: <?php echo $plano['duracao']; ?> dias</p>

        <form action="php/aluno/assinar_plano.php" method="POST">
            <input type="hidden" name="plano_id" value="<?php echo htmlspecialchars($plano_id); ?>">
            
            <label for="metodo_pagamento">Método de Pagamento:</label>
            <select name="metodo_pagamento" id="metodo_pagamento" required>
                <option value="">Selecione</option>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Cartão de Débito">Cartão de Débito</option>
                <option value="Boleto">Boleto</option>
                <option value="Pix">Pix</option>
            </select>
            <br>
            
            <label for="data_pagamento">Data de Pagamento:</label>
            <input type="date" name="data_pagamento" id="data_pagamento" required>
            <br>
            
            <button type="submit">Confirmar Assinatura</button>
        </form>

        <a href="aluno_buscar_academias.php">Voltar</a>
    </main>
    <!-- Validação no Frontend -->
    <script>
    document.querySelector("form").addEventListener("submit", function(event) {
        const metodoPagamento = document.getElementById("metodo_pagamento").value;
        const dataPagamento = document.getElementById("data_pagamento").value;
        const hoje = new Date();
        const dataPagamentoDate = new Date(dataPagamento);
        const dataLimite = new Date();
        dataLimite.setFullYear(dataLimite.getFullYear() + 1);

        let erros = [];

        if (!metodoPagamento) {
            erros.push("Selecione um método de pagamento.");
        }

        if (!dataPagamento) {
            erros.push("Informe a data de pagamento.");
        } else {
            if (isNaN(dataPagamentoDate.getTime())) {
                erros.push("Data de pagamento inválida.");
            } else {
                if (dataPagamentoDate < hoje) {
                    erros.push("A data de pagamento não pode ser no passado.");
                }
                if (dataPagamentoDate > dataLimite) {
                    erros.push("A data de pagamento não pode ser superior a 1 ano.");
                }
            }
        }

        if (erros.length > 0) {
            alert(erros.join("\n"));
            event.preventDefault(); // Impede o envio do formulário
        }
    });
    </script>
</body>

</html>
