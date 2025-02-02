<?php
// Iniciar a sessão e incluir o arquivo de conexão
session_start();
include('../conexao.php');  // Verifique se o caminho para o arquivo de conexão está correto

// Definir cabeçalho para JSON
header('Content-Type: application/json');

// Verificar se o parâmetro 'academia_id' foi passado
if (!isset($_GET['academia_id'])) {
    echo json_encode(['error' => 'Parâmetro academia_id é obrigatório.']);
    exit();
}

// Obter o ID da academia a partir do parâmetro GET
$academia_id = $_GET['academia_id'];

// Verificar se academia_id está correto (depuração)
if (!is_numeric($academia_id)) {
    echo json_encode(['error' => 'Parâmetro academia_id deve ser numérico.']);
    exit();
}

// Definir a consulta SQL para contar alunos ativos e inativos
$query = "
    SELECT
        SUM(CASE WHEN s.status = 'ativo' THEN 1 ELSE 0 END) AS ativos,
        SUM(CASE WHEN s.status = 'inativo' THEN 1 ELSE 0 END) AS inativos
    FROM assinatura s
    JOIN planos p ON s.Planos_id = p.id
    WHERE p.Academia_id = ?
";

// Preparar a consulta SQL
$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo json_encode(['error' => 'Erro ao preparar a consulta SQL.']);
    exit();
}

// Vincular o parâmetro
$stmt->bind_param("i", $academia_id); // "i" significa inteiro

// Executar a consulta
$stmt->execute();

// Obter o resultado
$result = $stmt->get_result();

// Verificar se encontrou algum resultado
if ($data = $result->fetch_assoc()) {
    // Verifique se o resultado contém dados válidos
    if ($data['ativos'] === null && $data['inativos'] === null) {
        echo json_encode(['error' => 'Nenhum dado encontrado para o ID da academia especificado.']);
    } else {
        echo json_encode($data);
    }
} else {
    echo json_encode(['error' => 'Erro na consulta.']);
}

// Fechar a declaração
$stmt->close();

// Fechar a conexão
$conn->close();
?>
