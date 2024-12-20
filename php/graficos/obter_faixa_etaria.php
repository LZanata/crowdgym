<?php
// Ativar exibição de erros para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexao.php';

try {
    // ID da academia recebido como parâmetro
    $academiaId = isset($_GET['academiaId']) ? (int) $_GET['academiaId'] : null;

    if (!$academiaId) {
        throw new Exception('ID da academia não fornecido.');
    }

    // SQL ajustado para usar a tabela 'aluno'
    $sql = "
        SELECT 
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, aluno.data_nascimento, CURDATE()) < 18 THEN 'Menores de 18'
                WHEN TIMESTAMPDIFF(YEAR, aluno.data_nascimento, CURDATE()) BETWEEN 18 AND 25 THEN '18-25 anos'
                WHEN TIMESTAMPDIFF(YEAR, aluno.data_nascimento, CURDATE()) BETWEEN 26 AND 35 THEN '26-35 anos'
                WHEN TIMESTAMPDIFF(YEAR, aluno.data_nascimento, CURDATE()) BETWEEN 36 AND 50 THEN '36-50 anos'
                ELSE 'Acima de 50'
            END AS faixa_etaria,
            COUNT(*) AS quantidade
        FROM 
            aluno
        INNER JOIN 
            assinatura ON aluno.id = assinatura.Aluno_id
        WHERE 
            assinatura.status = 'ativo' 
            AND assinatura.Planos_id IN (
                SELECT id FROM planos WHERE Academia_id = ?
            )
        GROUP BY 
            faixa_etaria
        ORDER BY 
            faixa_etaria
    ";

    // Preparar e executar a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $academiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Converter resultados para JSON
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
