<?php
include('../conexao.php');

// Obtendo os parâmetros passados via GET (ID da academia e intervalo de dias)
$academia_id = $_GET['academia_id'];  // ID da academia
$intervalo = $_GET['dias'];  // Intervalo de tempo em dias

// A consulta SQL para contar a quantidade de alunos com o plano principal no intervalo especificado
$query = "
    SELECT 
        COUNT(DISTINCT a.id) AS alunos_matriculados
    FROM 
        aluno a
    JOIN 
        assinatura s ON a.id = s.Aluno_id
    JOIN 
        planos p ON s.Planos_id = p.id
    JOIN 
        academia ac ON p.Academia_id = ac.id  -- Junção com a tabela academia
    WHERE 
        p.tipo = 'Principal' 
        AND ac.id = ?  -- Filtra pela academia associada ao plano
        AND s.data_inicio >= CURDATE() - INTERVAL ? DAY
";

// Preparar a consulta
$stmt = $conn->prepare($query);

// Bind os parâmetros para a consulta (ID da academia e intervalo de dias)
$stmt->bind_param('ii', $academia_id, $intervalo);

// Executar a consulta
$stmt->execute();

// Obter o resultado
$result = $stmt->get_result();

// Verificar se retornou algum resultado
if ($result->num_rows > 0) {
    // Fetch a linha de resultado
    $row = $result->fetch_assoc();
    $alunosMatriculados = $row['alunos_matriculados'];
} else {
    $alunosMatriculados = 0;  // Caso não haja resultados, retorna 0
}

// Retorna o valor em formato JSON
echo json_encode(['alunos_matriculados' => $alunosMatriculados]);

// Fechar a conexão
$stmt->close();
$conn->close();
?>
