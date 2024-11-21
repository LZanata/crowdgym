<?php
require_once 'conexao.php';
require_once '../cadastro_login/check_login_aluno.php'; // Verifica se o aluno está logado

// Verifica se o formulário foi submetido via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário
    $plano_id = isset($_POST['plano_id']) ? (int)$_POST['plano_id'] : 0;
    $metodo_pagamento = isset($_POST['metodo_pagamento']) ? trim($_POST['metodo_pagamento']) : '';
    $data_pagamento = isset($_POST['data_pagamento']) ? trim($_POST['data_pagamento']) : '';
    
    // Dados adicionais para pagamento
    $numero_cartao = isset($_POST['numero_cartao']) ? $_POST['numero_cartao'] : null;
    $nome_titular = isset($_POST['nome_titular']) ? $_POST['nome_titular'] : null;
    $validade_cartao = isset($_POST['validade_cartao']) ? $_POST['validade_cartao'] : null;
    $codigo_seguranca = isset($_POST['codigo_seguranca']) ? $_POST['codigo_seguranca'] : null;
    $cpf_titular = isset($_POST['cpf_titular']) ? $_POST['cpf_titular'] : null;
    $chave_pix = isset($_POST['chave_pix']) ? $_POST['chave_pix'] : null;

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
    if (strtotime($data_pagamento) < strtotime('today')) {
        echo "A data de pagamento não pode ser no passado.";
        exit;
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

    // Validação do método de pagamento
    if ($metodo_pagamento === 'Cartão de Crédito' || $metodo_pagamento === 'Cartão de Débito') {
        if (!$numero_cartao || !$nome_titular || !$validade_cartao || !$codigo_seguranca || !$cpf_titular) {
            $erros[] = "Erro: Todos os campos do cartão são obrigatórios.";
        }
    } elseif ($metodo_pagamento === 'Pix') {
        if (!$chave_pix) {
            $erros[] = "Erro: A chave Pix é obrigatória.";
        }
    }

    // Exibe os erros, caso existam
    if (!empty($erros)) {
        echo "Erro(s):<br>";
        foreach ($erros as $erro) {
            echo htmlspecialchars($erro) . "<br>";
        }
        echo '<br><a href="../../aluno_assinar_plano.php?plano_id=' . $plano_id . '">Voltar</a>';
        exit;
    }

    // Busca os detalhes do plano
    $queryPlano = $conexao->prepare("SELECT * FROM planos WHERE id = ?");
    if (!$queryPlano) {
        echo "Erro na preparação da consulta de plano: " . $conexao->error;
        exit;
    }
    $queryPlano->bind_param("i", $plano_id);
    $queryPlano->execute();
    $resultPlano = $queryPlano->get_result();

    if (!$resultPlano) {
        echo "Erro ao executar consulta de plano: " . $conexao->error;
        exit;
    }

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
        echo "Erro na preparação da inserção de assinatura: " . $conexao->error;
        exit;
    }

    echo "Parametros para inserção: ";
    echo "status = $status, data_inicio = $data_inicio, data_fim = $data_fim, metodo_pagamento = $metodo_pagamento, data_pagamento = $data_pagamento, valor_pago = $valor_pago, Planos_id = $plano_id, Aluno_id = " . $_SESSION['aluno_id'];

    $queryInserir->bind_param("sssssdii", $status, $data_inicio, $data_fim, $metodo_pagamento, $data_pagamento, $valor_pago, $plano_id, $_SESSION['aluno_id']);

    if ($queryInserir->execute()) {
        // Sucesso: Redireciona para a página de "Meus Planos" ou página de sucesso
        echo "Plano assinado com sucesso!";
        header("Location: ../../aluno_meus_planos.php"); // Redireciona para a página de planos do aluno
        exit;
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
    header("Location: http://localhost/Projeto_CrowdGym/aluno_buscar_academias.php?plano_id=1");
    exit;
}
?>
