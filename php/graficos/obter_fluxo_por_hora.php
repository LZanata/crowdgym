<?php
include '../cadastro_login/check_login_gerente.php';
include '../conexao.php'; 

header('Content-Type: application/json');

// ID da academia
$academia_id = isset($_GET['academia_id']) ? intval($_GET['academia_id']) : 0;

// Consulta para calcular o fluxo por hora e dia da semana
$query = "
    SELECT 
        DAYNAME(data_entrada) AS dia_semana,
        HOUR(data_entrada) AS hora,
        COUNT(*) / COUNT(DISTINCT DATE(data_entrada)) AS media_alunos
    FROM entradas_saidas
    WHERE academia_id = ? AND data_entrada IS NOT NULL
    GROUP BY dia_semana, hora
    ORDER BY FIELD(dia_semana, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), hora;
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $academia_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[$row['dia_semana']][] = [
        'hora' => intval($row['hora']),
        'media_alunos' => floatval($row['media_alunos']),
    ];
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
