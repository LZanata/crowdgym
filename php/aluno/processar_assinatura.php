<?php
require_once '../cadastro_login/check_login_aluno.php';
require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plano_id = isset($_POST['plano_id']) ? (int)$_POST['plano_id'] : 0;
    $metodo_pagamento = isset($_POST['metodo_pagamento']) ? $_POST['metodo_pagamento'] : '';
    $aluno_id = $_SESSION['aluno_id']; // Presume-se que o ID do aluno está na sessão.
    $status = 'ativo'; // Define o status como ativo por padrão.
    $data_inicio = date('Y-m-d'); // Data de início da assinatura.
    $valor_pago = 0;

    // Busca detalhes do plano para obter o valor e a duração
    $queryPlano = $conn->prepare("SELECT valor, duracao FROM planos WHERE id = ?");
    $queryPlano->bind_param("i", $plano_id);
    $queryPlano->execute();
    $plano = $queryPlano->get_result()->fetch_assoc();

    if (!$plano) {
        die("Plano inválido.");
    }

    $valor_pago = $plano['valor'];
    $data_fim = date('Y-m-d', strtotime("+{$plano['duracao']} days"));

    // Dados adicionais para métodos de pagamento
    $numero_cartao = null;
    $nome_titular = null;
    $validade_cartao = null;
    $codigo_seguranca = null;
    $cpf_titular = null;

    if ($metodo_pagamento === 'Cartão de Crédito' || $metodo_pagamento === 'Cartão de Débito') {
        $numero_cartao = $_POST['numero_cartao'] ?? null;
        $nome_titular = $_POST['nome_titular'] ?? null;
        $validade_cartao = $_POST['validade_cartao'] ?? null;
        $codigo_seguranca = $_POST['codigo_seguranca'] ?? null;
        $cpf_titular = $_POST['cpf_titular'] ?? null;

        // Validação básica para dados de cartão
        if (!$numero_cartao || !$nome_titular || !$validade_cartao || !$codigo_seguranca || !$cpf_titular) {
            die("Todos os campos do cartão devem ser preenchidos.");
        }
    }

    // Data de pagamento (simulação para métodos Pix/Boleto)
    $data_pagamento = $metodo_pagamento === 'Pix' || $metodo_pagamento === 'Boleto' 
                      ? null 
                      : date('Y-m-d');

    // Inserção no banco de dados
    $queryInserir = $conn->prepare("
        INSERT INTO assinatura 
        (status, data_inicio, data_fim, metodo_pagamento, data_pagamento, valor_pago, Planos_id, Aluno_id, 
         numero_cartao, nome_titular, validade_cartao, codigo_seguranca, cpf_titular) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $queryInserir->bind_param(
        "sssssdiiissss",
        $status,
        $data_inicio,
        $data_fim,
        $metodo_pagamento,
        $data_pagamento,
        $valor_pago,
        $plano_id,
        $aluno_id,
        $numero_cartao,
        $nome_titular,
        $validade_cartao,
        $codigo_seguranca,
        $cpf_titular
    );

    if ($queryInserir->execute()) {
        if ($metodo_pagamento === 'Pix') {
            // Redireciona para a página do Pix
            header("Location: http://localhost/Projeto_CrowdGym/lib/crowdgym-pix/index.php?plano_id=$plano_id");
            exit;
        } elseif ($metodo_pagamento === 'Boleto') {
            // Redireciona para a página de instruções do boleto
            header("Location: ../../pagamento_boleto.php");
            exit;
        } else {
            // Redireciona para a página padrão após o pagamento
            header("Location: http://localhost/Projeto_CrowdGym/aluno/minhas_academias.php?id=$id&success=1");
            exit;
        }
    } else {
        echo "Erro ao processar assinatura: " . $conn->error;
    }    
} else {
    die("Método de requisição inválido.");
}
?>
