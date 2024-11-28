<?php
include '../conexao.php';

header('Content-Type: application/json');

// Verificar se o ID da academia está na sessão
session_start();
if (!isset($_SESSION['Academia_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit;
}

$academia_id = $_SESSION['Academia_id'];
$data = date('Y-m-d'); // Use uma data específica se necessário

// Query para buscar o histórico diário
$query = $conexao->prepare("
    SELECT 
        HOUR(data_entrada) AS hora, 
        COUNT(*) AS total
    FROM 
        entrada_saida
    WHERE 
        DATE(data_entrada) = ?
        AND Academia_id = ?
    GROUP BY 
        HOUR(data_entrada)
    ORDER BY 
        hora ASC;
");
$query->bind_param('si', $data, $academia_id);
$query->execute();
$resultado = $query->get_result();

$dados = [];
while ($row = $resultado->fetch_assoc()) {
    $dados[] = [
        'hora' => str_pad($row['hora'], 2, '0', STR_PAD_LEFT) . ':00', // Formato "HH:00"
        'total' => $row['total']
    ];
}

echo json_encode($dados);
?>
