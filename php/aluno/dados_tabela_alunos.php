<?php
include '../conexao.php';

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta SQL para buscar o fluxo de alunos por semana
$sql = "SELECT WEEK(data) AS semana, SUM(alunos) AS total_alunos
        FROM fluxo
        GROUP BY WEEK(data)";

$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    $semanas = [];
    $alunos = [];

    // Processa os resultados
    while($row = $result->fetch_assoc()) {
        $semanas[] = "Semana " . $row["semana"];
        $alunos[] = $row["total_alunos"];
    }

    // Retorna os dados como JSON
    echo json_encode([
        "semanas" => $semanas,
        "alunos" => $alunos
    ]);
} else {
    echo json_encode([
        "semanas" => [],
        "alunos" => []
    ]);
}

// Fecha a conexão
$conn->close();
?>