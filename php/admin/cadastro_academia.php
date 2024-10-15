<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $dia_semana = $_POST['dia_semana'];
    $abertura = $_POST['abertura'];
    $fechamento = $_POST['fechamento'];

    // Inserir os dados no banco de dados
    $query = "INSERT INTO academia (nome, telefone, rua, numero, complemento, bairro, cidade, estado, cep, dia_semana, abertura, fechamento) VALUES ('$nome','$telefone', '$rua', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$cep', '$dia_semana', '$abertura', '$fechamento')";

    if (mysqli_query($conexao, $query)) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o usuário: " . mysqli_error($conexao);
    }
}

?>