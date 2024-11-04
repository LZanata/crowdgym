<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dados do aluno
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $genero = $_POST['genero'];
    $data_nascimento = $_POST['data_nascimento'] ?? null;

    // Verifica se o upload da foto foi feito corretamente
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $fotoNome = uniqid() . '-' . $foto['name']; // Nome único para evitar conflitos
        $fotoCaminho = 'uploads/' . $fotoNome; // Caminho onde a foto será salva

        // Move o arquivo para o diretório desejado
        if (move_uploaded_file($foto['tmp_name'], $fotoCaminho)) {
            // Insere os dados do aluno no banco de dados
            $query = "INSERT INTO aluno (nome, email, cpf, senha, genero, data_nascimento, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($query);
            $stmt->bind_param("sssssss", $nome, $email, $cpf, $senha, $genero, $data_nascimento, $fotoCaminho);
            
            if ($stmt->execute()) {
                echo "Aluno cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar aluno: " . $stmt->error;
            }
        } else {
            echo "Erro ao salvar a foto.";
        }
    } else {
        echo "Erro no upload da foto.";
    }
}
?>
