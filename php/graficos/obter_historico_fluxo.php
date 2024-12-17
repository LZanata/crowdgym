<?php
include '../conexao.php';

if (isset($_GET['academia_id'])) {
    $academia_id = intval($_GET['academia_id']);

    // Define o dia atual
    $hoje = date('Y-m-d');

    // Inicializa os horários do dia com valores zerados
    $horarios = [];
    for ($hora = 0; $hora < 24; $hora++) {
        $horarios[sprintf('%02d:00', $hora)] = 0;
    }

    // Consulta os dados de hoje
    $query = $conn->prepare("
        SELECT 
            HOUR(data_entrada) AS hora,
            COUNT(*) AS total_alunos
        FROM 
            entrada_saida
        WHERE 
            Academia_id = ? AND 
            DATE(data_entrada) = ?
        GROUP BY 
            HOUR(data_entrada)
        ORDER BY 
            hora;
    ");
    $query->bind_param("is", $academia_id, $hoje);
    $query->execute();

    $resultado = $query->get_result();

    // Preenche os valores nos horários correspondentes
    while ($row = $resultado->fetch_assoc()) {
        $horarios[sprintf('%02d:00', $row['hora'])] = $row['total_alunos'];
    }

    // Prepara os dados para o gráfico
    $dados = [
        'labels' => array_keys($horarios),
        'values' => array_values($horarios),
    ];

    echo json_encode($dados);
} else {
    echo json_encode(['erro' => 'Academia_id não fornecido']);
}
?>
