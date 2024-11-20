<?php
require_once 'conexao.php';
require_once '../cadastro_login/check_login_aluno.php';

// Verifica se o formulário foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário
    $plano_id = isset($_POST['plano_id']) ? (int)$_POST['plano_id'] : 0;
    $metodo_pagamento = isset($_POST['metodo_pagamento']) ? trim($_POST['metodo_pagamento']) : '';
    $data_pagamento = isset($_POST['data_pagamento']) ? trim($_POST['data_pagamento']) : '';

    // Validações
    $erros = [];

    if (!$plano_id) {
        $erros[] = "ID do plano não foi informado.";
    }
    if (empty($metodo_pagamento)) {
        $erros[] = "Selecione um método de pagamento.";
    }
    if (empty($data_pagamento)) {
        $erros[] = "Informe a data de pagamento.";
    }

    // Validação da data de pagamento
    $data_obj = DateTime::createFromFormat('Y-m-d', $data_pagamento);
    if (!$data_obj || $data_obj->format('Y-m-d') !== $data_pagamento) {
        $erros[] = "Data de pagamento inválida.";
    } else {
        $hoje = new DateTime();
        $data_pagamento_dt = new DateTime($data_pagamento);

        if ($data_pagamento_dt < $hoje) {
            $erros[] = "A data de pagamento não pode ser no passado.";
        }

        $data_limite = (clone $hoje)->modify('+1 year');
        if ($data_pagamento_dt > $data_limite) {
            $erros[] = "A data de pagamento não pode ser superior a 1 ano.";
        }
    }

    if (!empty($erros)) {
        // Exibe os erros e encerra o processamento
        echo "Erro(s):<br>";
        foreach ($erros as $erro) {
            echo htmlspecialchars($erro) . "<br>";
        }
        echo '<a href="../../aluno_assinar_plano.php?plano_id=' . $plano_id . '">Voltar</a>';
        exit;
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

    // Calcula datas de início e fim da assinatura
    $data_inicio = date('Y-m-d');
    $data_fim = date('Y-m-d', strtotime("+{$plano['duracao']} days"));
    $valor_pago = (float)$plano['valor'];
    $status = 'ativo';

    // Verifica se o aluno já assinou este plano
    $queryAssinatura = $conexao->prepare("SELECT * FROM assinatura WHERE Planos_id = ? AND Aluno_id = ? AND status = 'ativo'");
    if (!$queryAssinatura) {
        echo "Erro na preparação da consulta de assinatura: " . $conexao->error;
        exit;
    }
    $queryAssinatura->bind_param("ii", $plano_id, $_SESSION['aluno_id']);
    $queryAssinatura->execute();
    $resultAssinatura = $queryAssinatura->get_result();

    if ($resultAssinatura->num_rows > 0) {
        echo "Você já assinou este plano.";
        echo '<br><a href="../../aluno_buscar_academias.php">Voltar</a>';
        exit;
    }

    // Insere a assinatura
    $queryInserir = $conexao->prepare("INSERT INTO assinatura (status, data_inicio, data_fim, metodo_pagamento, data_pagamento, valor_pago, Planos_id, Aluno_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$queryInserir) {
        echo "Erro na preparação da inserção: " . $conexao->error;
        exit;
    }
    $queryInserir->bind_param("sssssdii", $status, $data_inicio, $data_fim, $metodo_pagamento, $data_pagamento, $valor_pago, $plano_id, $_SESSION['aluno_id']);

    if ($queryInserir->execute()) {
        echo "Plano assinado com sucesso!";
        echo '<br><a href="../../aluno_buscar_academias.php">Voltar</a>';
    } else {
        echo "Erro ao processar a assinatura: " . $queryInserir->error;
        echo '<br><a href="../../aluno_assinar_plano.php?plano_id=' . $plano_id . '">Voltar</a>';
    }

    // Fecha conexões
    $queryPlano->close();
    $queryAssinatura->close();
    $queryInserir->close();
    $conexao->close();
} else {
    // Se o método não for POST, redireciona para a página de busca
    header("Location: http://localhost/Projeto_CrowdGym/aluno_buscar_academias.php");
    exit;
}
?>
