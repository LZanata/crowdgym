<?php
require_once '../conexao.php';
require_once '../cadastro_login/check_login_aluno.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o ID do plano e o ID do aluno
    $plano_id = isset($_POST['plano_id']) ? (int)$_POST['plano_id'] : 0;
    $aluno_id = $_SESSION['aluno_id']; // Certifique-se de que o aluno está autenticado.

    // Verifica se a assinatura está ativa
    $query = $conn->prepare("
        SELECT id FROM assinatura 
        WHERE Planos_id = ? AND Aluno_id = ? AND status = 'ativo'
    ");
    $query->bind_param("ii", $plano_id, $aluno_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        echo "Assinatura inválida ou já inativa.";
        exit;
    }

    // Atualiza o status para 'inativo' e ajusta a data de término
    $queryCancelar = $conn->prepare("
        UPDATE assinatura 
        SET status = 'inativo', data_fim = CURDATE()
        WHERE Planos_id = ? AND Aluno_id = ?
    ");
    $queryCancelar->bind_param("ii", $plano_id, $aluno_id);

    if ($queryCancelar->execute()) {
        // Redireciona para a página de academias com mensagem de sucesso
        header("Location: http://localhost/Projeto_CrowdGym/aluno/minhas_academias.php?success=1");
        exit;
    } else {
        echo "Erro ao cancelar assinatura: " . $conn->error;
    }
} else {
    echo "Método de requisição inválido.";
}
?>
