<?php
include('conexao.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']);
    $senha = trim($_POST['senha']);
    $cargo = trim($_POST['cargo']);
    $data_contrat = $_POST['data_contrat'];
    $genero = $_POST['genero'];

    // Validação básica
    if (empty($id) || empty($nome) || empty($email) || empty($cpf) || empty($cargo) || empty($data_contrat) || empty($genero)) {
        echo "Todos os campos são obrigatórios.";
        exit;
    }

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Query de atualização
    $sql = "UPDATE funcionario SET nome=?, email=?, cpf=?, senha=?, cargo=?, data_contrat=?, genero=? WHERE id=?";

    // Preparação e execução da query
    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("sssssssi", $nome, $email, $cpf, $senhaHash, $cargo, $data_contrat, $genero, $id);
        
        if ($stmt->execute()) {
            echo "Cadastro atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro na preparação da query: " . $conexao->error;
    }

    $conexao->close();
} else {
    echo "Método inválido.";
}
?>
