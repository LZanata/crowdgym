<?php
include '../conexao.php';

if (isset($_GET['academia_id'])) {
    $academia_id = intval($_GET['academia_id']);

    $query = $conexao->prepare("
        SELECT 
            DATE_FORMAT(data_entrada, '%Y-%m-%d %H:00:00') AS hora,
            COUNT(*) AS total_alunos
        FROM 
            entrada_saida
        WHERE 
            Academia_id = ?
        GROUP BY 
            DATE_FORMAT(data_entrada, '%Y-%m-%d %H:00:00')
        ORDER BY 
            hora;
    ");
    $query->bind_param("i", $academia_id);
    $query->execute();

    $resultado = $query->get_result();
    $dados = [];

    while ($row = $resultado->fetch_assoc()) {
        $dados['labels'][] = $row['hora'];
        $dados['values'][] = $row['total_alunos'];
    }

    echo json_encode($dados);
} else {
    echo json_encode(['erro' => 'Academia_id não fornecido']);
}
?>