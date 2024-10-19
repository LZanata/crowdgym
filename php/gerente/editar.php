<?php
include('conexao.php'); // Inclua sua conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $cargo = $_POST['cargo'];
    $data_contrat = $_POST['data_contrat'];
    $genero = $_POST['genero'];

    // Query de atualização
    $sql = "UPDATE funcionario SET nome=?, email=?, cpf=?, senha=?, cargo=?, data_contrat=?, genero=? WHERE id=?";

    // Preparação e execução da query
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("sssssssi", $nome, $email, $cpf, $senha, $cargo, $data_contrat, $genero, $id);
        
        if ($stmt->execute()) {
            echo "Cadastro atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar: " . $stmt->error;
        }

        $stmt->close();
    }

    $conexao->close();
} else {
    echo "Método inválido.";
}
?>
