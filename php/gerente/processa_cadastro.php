<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha
    $cargo = $_POST['cargo'];
    $data_contrat = $_POST['data_contrat'];
    $genero = $_POST['genero'];

    // Inserir os dados no banco de dados
    $query = "INSERT INTO funcionario (cpf, nome, email, senha, cargo, data_contrat, genero) VALUES ('$nome', '$email', '$senha', '$cargo', '$data_contrat', '$genero')";
    if (mysqli_query($conexao, $query)) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o usuário: " . mysqli_error($conexao);
    }
}
?>
