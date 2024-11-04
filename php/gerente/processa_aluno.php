<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do aluno
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $plano_id = $_POST['plano'];
    $data_inicio = date("Y-m-d");

    // Validação básica
    if (empty($nome) || empty($email) || empty($cpf) || empty($senha) || empty($plano_id)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit;
    }

    // Verificação de confirmação de senha
    if ($senha !== $confirma_senha) {
        echo "As senhas não coincidem.";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Iniciar uma transação
    $conexao->begin_transaction();

    try {
        // Insere o aluno
        $stmt_aluno = $conexao->prepare("INSERT INTO aluno (nome, email, cpf, senha) VALUES (?, ?, ?, ?)");
        $stmt_aluno->bind_param("ssss", $nome, $email, $cpf, $senha_hash);
        $stmt_aluno->execute();
        $aluno_id = $stmt_aluno->insert_id; // Obtém o ID do aluno recém-cadastrado

        // Consultar o valor do plano selecionado
        $stmt_plano = $conexao->prepare("SELECT valor FROM planos WHERE id = ?");
        $stmt_plano->bind_param("i", $plano_id);
        $stmt_plano->execute();
        $stmt_plano->bind_result($valor_pago);
        $stmt_plano->fetch();
        $stmt_plano->close();

        // Configurar datas e valores para a assinatura
        $data_fim = date("Y-m-d", strtotime("+1 month")); // Exemplo: plano mensal

        // Insere a assinatura
        $stmt_assinatura = $conexao->prepare("INSERT INTO assinatura (status, valor_pago, data_inicio, data_fim, Planos_id, Aluno_id) VALUES (?, ?, ?, ?, ?, ?)");
        $status = 'ativo';
        $stmt_assinatura->bind_param("sdssii", $status, $valor_pago, $data_inicio, $data_fim, $plano_id, $aluno_id);
        $stmt_assinatura->execute();

        // Confirma a transação
        $conexao->commit();

        echo "Aluno cadastrado e assinatura criada com sucesso!";
    } catch (Exception $e) {
        $conexao->rollback(); // Desfaz a transação em caso de erro
        echo "Erro ao cadastrar aluno e assinatura: " . $e->getMessage();
    }
}
?>
