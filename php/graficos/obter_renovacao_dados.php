<?php
include '../cadastro_login/check_login_gerente.php';
include '../conexao.php';

$academiaId = $_SESSION['Academia_id']; 

$query = "
    SELECT
        SUM(CASE WHEN status = 'ativo' AND data_fim > NOW() THEN 1 ELSE 0 END) AS renovados,
        SUM(CASE WHEN (status = 'inativo' OR data_fim < NOW()) THEN 1 ELSE 0 END) AS expirados
    FROM assinatura
    INNER JOIN planos ON assinatura.Planos_id = planos.id
    WHERE planos.Academia_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $academiaId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>
