<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do aluno
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $plano_id = $_POST['plano'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $data_inicio = date("Y-m-d");

    // Validação básica
    if (empty($nome) || empty($email) || empty($cpf) || empty($senha) || empty($plano_id) || empty($data_nascimento) || empty($genero) || empty($_FILES['foto'])) {
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

    // Processamento da foto
    $foto_dir = '../uploads/';

    // Verifica se a pasta uploads existe, caso contrário, cria
    if (!file_exists($foto_dir)) {
        mkdir($foto_dir, 0755, true);
    }

    $foto_nome = basename($_FILES['foto']['name']);
    $foto_caminho = $foto_dir . uniqid() . "_" . $foto_nome;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_caminho)) {
        echo "Erro ao fazer upload da foto.";
        exit;
    }


    // Iniciar uma transação
    $conn->begin_transaction();

    try {
        // Insere o aluno com os campos adicionais
        $stmt_aluno = $conn->prepare("INSERT INTO aluno (nome, email, cpf, senha, data_nascimento, genero, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_aluno->bind_param("sssssss", $nome, $email, $cpf, $senha_hash, $data_nascimento, $genero, $foto_caminho);
        $stmt_aluno->execute();
        $aluno_id = $stmt_aluno->insert_id; // Obtém o ID do aluno recém-cadastrado

        // Consultar o valor do plano selecionado
        $stmt_plano = $conn->prepare("SELECT valor FROM planos WHERE id = ?");
        $stmt_plano->bind_param("i", $plano_id);
        $stmt_plano->execute();
        $stmt_plano->bind_result($valor_pago);
        $stmt_plano->fetch();
        $stmt_plano->close();

        // Configurar datas e valores para a assinatura
        $data_fim = date("Y-m-d", strtotime("+1 month")); // Exemplo: plano mensal

        // Insere a assinatura
        $stmt_assinatura = $conn->prepare("INSERT INTO assinatura (status, valor_pago, data_inicio, data_fim, Planos_id, Aluno_id) VALUES (?, ?, ?, ?, ?, ?)");
        $status = 'ativo';
        $stmt_assinatura->bind_param("sdssii", $status, $valor_pago, $data_inicio, $data_fim, $plano_id, $aluno_id);
        $stmt_assinatura->execute();

        // Confirma a transação
        $conn->commit();

        echo "Aluno cadastrado e assinatura criada com sucesso!";
    } catch (Exception $e) {
        $conn->rollback(); // Desfaz a transação em caso de erro
        echo "Erro ao cadastrar aluno e assinatura: " . $e->getMessage();
    }
}
