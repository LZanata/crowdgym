<?php
include '../php/conexao.php';
include '../php/cadastro_login/check_login_funcionario.php'; 

if (!isset($_GET['aluno_id'])) {
    echo "Aluno não especificado.";
    exit;
}

$aluno_id = $_GET['aluno_id'];

// Buscar os detalhes do aluno no banco de dados
$query = $conn->prepare("
    SELECT nome, cpf, email, genero, data_nascimento, foto
    FROM aluno
    WHERE id = ?
");
$query->bind_param("i", $aluno_id);
$query->execute();
$resultado = $query->get_result();

if ($resultado->num_rows == 0) {
    echo "Aluno não encontrado.";
    exit;
}

$aluno = $resultado->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Aluno</title>
</head>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6827a6cd36f29c190d216342/1irdh4qa7';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body>
    <h1>Detalhes do Aluno</h1>
    <p><strong>Nome:</strong> <?= htmlspecialchars($aluno['nome']) ?></p>
    <p><strong>CPF:</strong> <?= htmlspecialchars($aluno['cpf']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($aluno['email']) ?></p>
    <p><strong>Gênero:</strong> <?= htmlspecialchars($aluno['genero']) ?></p>
    <p><strong>Data de Nascimento:</strong> <?= htmlspecialchars($aluno['data_nascimento']) ?></p>
    <?php if ($aluno['foto']): ?>
        <p><strong>Foto:</strong></p>
        <img src="uploads/<?= htmlspecialchars($aluno['foto']) ?>" alt="Foto do Aluno" width="150">
    <?php endif; ?>
    <a href="entrada_saida.php">Voltar</a>
</body>
</html>
