<?php
include '../php/conexao.php';
include '../php/cadastro_login/check_login_funcionario.php';

function buscarAluno($cpf, $academia_id, $conn) {
    $query = $conn->prepare("
        SELECT a.id, a.nome, a.cpf, p.tipo, ass.status
        FROM aluno a
        JOIN assinatura ass ON ass.Aluno_id = a.id
        JOIN planos p ON p.id = ass.Planos_id
        WHERE a.cpf = ? AND p.tipo = 'Principal' AND ass.status = 'ativo' AND p.Academia_id = ?
    ");
    $query->bind_param("si", $cpf, $academia_id);
    $query->execute();
    $resultado = $query->get_result();

    return $resultado->fetch_assoc();
}

function liberarEntradaOuSaida($aluno_id, $academia_id, $acao, $conn) {
    if ($acao === 'entrada') {
        // Verificar se já há uma entrada não finalizada
        $query = $conn->prepare("
            SELECT id FROM entrada_saida
            WHERE Aluno_id = ? AND Academia_id = ? AND data_saida IS NULL
        ");
        $query->bind_param("ii", $aluno_id, $academia_id);
        $query->execute();
        $resultado = $query->get_result();

        if ($resultado->num_rows > 0) {
            return "Aluno já está registrado como dentro da academia.";
        }

        // Registrar entrada
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
    } elseif ($acao === 'saida') {
        // Registrar saída
        $query = $conn->prepare("
            UPDATE entrada_saida
            SET data_saida = NOW()
            WHERE Aluno_id = ? AND Academia_id = ? AND data_saida IS NULL
        ");
        $query->bind_param("ii", $aluno_id, $academia_id);
        if ($query->execute() && $query->affected_rows > 0) {
            return "Saída registrada com sucesso.";
        } else {
            return "Nenhuma entrada em aberto para registrar a saída.";
        }
    }

    return "Ação inválida.";
}

$mensagem = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cpf'], $_POST['acao'])) {
    $cpf = $_POST['cpf'];
    $acao = $_POST['acao'];
    $academia_id = $_SESSION['Academia_id']; // ID da academia do funcionário logado

    // Buscar aluno
    $aluno = buscarAluno($cpf, $academia_id, $conn);
    if (!$aluno) {
        $mensagem = "Aluno não encontrado ou sem plano principal ativo.";
    } else {
        // Liberar entrada ou saída
        $mensagem = liberarEntradaOuSaida($aluno['id'], $academia_id, $acao, $conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catraca</title>
    <link rel="stylesheet" href="../css/index.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6827a6cd36f29c190d216342/1irdh4qa7';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body>
    <!--Nesta tela deverá aparecer os dados de funcionamento da catraca e as opções de liberar e fechar acesso da catraca-->
    <?php include '../partials/header_funcionario.php'; ?> <!-- Inclui o cabeçalho -->
    <main>
        <h1>Acesso de Catraca</h1>
        <?php if (!empty($mensagem)): ?>
            <p><strong><?= htmlspecialchars($mensagem) ?></strong></p>
        <?php endif; ?>
        <form method="POST">
            <label for="cpf">CPF do Aluno:</label>
            <input type="text" name="cpf" id="cpf" required>
            <button type="submit" name="acao" value="entrada">Liberar Entrada</button>
            <button type="submit" name="acao" value="saida">Liberar Saída</button>
        </form>
    </main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>