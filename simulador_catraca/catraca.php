<?php
include '../php/conexao.php';

function registrarEntradaSaida($cpf, $academia_id, $conexao) {
    // Obter o ID do aluno pelo CPF
    $query = $conexao->prepare("SELECT id FROM aluno WHERE cpf = ?");
    $query->bind_param("s", $cpf);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows == 0) {
        return "Aluno não encontrado.";
    }

    $aluno = $resultado->fetch_assoc();
    $aluno_id = $aluno['id'];

    // Verificar se o aluno possui um plano principal ativo na academia
    $query = $conexao->prepare("
        SELECT p.id 
        FROM assinatura a
        INNER JOIN planos p ON a.Planos_id = p.id
        WHERE a.Aluno_id = ? AND p.Academia_id = ? AND p.tipo = 'Principal' AND a.status = 'ativo'
          AND a.data_inicio <= CURDATE() AND a.data_fim >= CURDATE()
    ");
    $query->bind_param("ii", $aluno_id, $academia_id);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows == 0) {
        return "Aluno não possui um plano principal ativo nesta academia.";
    }

    // Verificar se já existe uma entrada sem saída
    $query = $conexao->prepare("
        SELECT id 
        FROM entrada_saida
        WHERE Aluno_id = ? AND Academia_id = ? AND DATE(data_entrada) = CURDATE() AND data_saida IS NULL
    ");
    $query->bind_param("ii", $aluno_id, $academia_id);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows > 0) {
        // Registrar saída
        $entrada_saida = $resultado->fetch_assoc();
        $query = $conexao->prepare("
            UPDATE entrada_saida
            SET data_saida = NOW()
            WHERE id = ?
        ");
        $query->bind_param("i", $entrada_saida['id']);
        if ($query->execute()) {
            return "Saída registrada com sucesso.";
        } else {
            return "Erro ao registrar saída: " . $conexao->error;
        }
    } else {
        // Registrar entrada
        $query = $conexao->prepare("
            INSERT INTO entrada_saida (data_entrada, Academia_id, Aluno_id)
            VALUES (NOW(), ?, ?)
        ");
        $query->bind_param("ii", $academia_id, $aluno_id);
        if ($query->execute()) {
            return "Entrada registrada com sucesso.";
        } else {
            return "Erro ao registrar entrada: " . $conexao->error;
        }
    }
}

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $academia_id = $_POST['academia_id'];

    $mensagem = registrarEntradaSaida($cpf, $academia_id, $conexao);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Catraca</title>
</head>
<body>
    <h1>Simulador de Catraca</h1>
    <?php if (isset($mensagem)): ?>
        <p><strong><?= htmlspecialchars($mensagem) ?></strong></p>
    <?php endif; ?>
    <form method="POST">
        <label for="cpf">CPF do Aluno:</label>
        <input type="text" name="cpf" id="cpf" required>
        <label for="academia_id">ID da Academia:</label>
        <input type="text" name="academia_id" id="academia_id" required>
        <button type="submit">Registrar Entrada/Saída</button>
    </form>
</body>
</html>
