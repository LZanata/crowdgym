<?php
include 'conexao.php';

function registrarEntrada($cpf, $academia_id, $conn)
{
    // Obter o ID do aluno pelo CPF
    $query = $conn->prepare("SELECT id FROM aluno WHERE cpf = ?");
    $query->bind_param("s", $cpf);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows == 0) {
        return "Aluno não encontrado.";
    }

    $aluno = $resultado->fetch_assoc();
    $aluno_id = $aluno['id'];

    // Verificar se já existe uma entrada sem saída
    $query = $conn->prepare("
        SELECT * FROM entrada_saida
        WHERE Aluno_id = ? AND Academia_id = ? AND DATE(data_entrada) = CURDATE() AND data_saida IS NULL
    ");
    $query->bind_param("ii", $aluno_id, $academia_id);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows > 0) {
        return "Entrada já registrada para hoje.";
    }

    // Inserir nova entrada
    $query = $conn->prepare("
        INSERT INTO entrada_saida (data_entrada, Academia_id, Aluno_id)
        VALUES (NOW(), ?, ?)
    ");
    $query->bind_param("ii", $academia_id, $aluno_id);
    if ($query->execute()) {
        return "Entrada registrada com sucesso.";
    } else {
        return "Erro ao registrar entrada: " . $conn->error;
    }
}

function registrarSaida($cpf, $academia_id, $conn)
{
    // Obter o ID do aluno pelo CPF
    $query = $conn->prepare("SELECT id FROM aluno WHERE cpf = ?");
    $query->bind_param("s", $cpf);
    $query->execute();
    $resultado = $query->get_result();

    if ($resultado->num_rows == 0) {
        return "Aluno não encontrado.";
    }

    $aluno = $resultado->fetch_assoc();
    $aluno_id = $aluno['id'];

    // Atualizar saída para o registro mais recente
    $query = $conn->prepare("
        UPDATE entrada_saida
        SET data_saida = NOW()
        WHERE Aluno_id = ? AND Academia_id = ? AND DATE(data_entrada) = CURDATE() AND data_saida IS NULL
    ");
    $query->bind_param("ii", $aluno_id, $academia_id);
    if ($query->execute() && $query->affected_rows > 0) {
        return "Saída registrada com sucesso.";
    } else {
        return "Nenhuma entrada aberta encontrada.";
    }
}

// Processar o formulário apenas quando ele for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    $cpf = $_POST['cpf'];
    $academia_id = $_POST['academia_id'];
    $acao = $_POST['acao'];

    if ($acao === 'entrada') {
        $mensagem = registrarEntrada($cpf, $academia_id, $conn);
    } elseif ($acao === 'saida') {
        $mensagem = registrarSaida($cpf, $academia_id, $conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Catraca</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <main>
        <div class="container">
            <div class="header">
                <h1>Catraca</h1>
                <?php if (isset($mensagem)): ?>
                    <p class="mensagem" id="mensagem"><strong><?= htmlspecialchars($mensagem) ?></strong></p>
                <?php endif; ?>
            </div>
            <div class="form">
                <form method="POST">
                    <div class="input-group">
                        <div class="input-box">
                            <label for="cpf">CPF do Aluno:</label>
                            <input type="text" name="cpf" 
                            placeholder="Digite o CPF"
                            id="cpf" required>
                        </div>
                        <div class="input-box">
                            <label for="academia_id">ID da Academia:</label>
                            <input type="text" name="academia_id"
                            placeholder="Digite o ID" id="academia_id" required>
                        </div>
                    </div>
                    <div class="button">
                        <button type="submit" name="acao" value="entrada">Registrar Entrada</button>
                        <button type="submit" name="acao" value="saida">Registrar Saída</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        // Função para ocultar a mensagem após 3 segundos
        setTimeout(() => {
            const mensagem = document.getElementById('mensagem');
            if (mensagem) {
                mensagem.classList.add('oculta');
                // Remove do DOM após a animação
                setTimeout(() => mensagem.remove(), 1000);
            }
        }, 3000); // 3 segundos
    </script>
</body>

</html>