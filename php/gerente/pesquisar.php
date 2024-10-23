<?php
include 'conexao.php';

// Verifica se o parâmetro de pesquisa foi fornecido
$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';

// Consulta para buscar os funcionários, com ou sem filtro de pesquisa
$query = "SELECT id, nome, email FROM funcionario";
if (!empty($pesquisa)) {
    $query .= " WHERE nome LIKE ? OR email LIKE ?";
}

// Prepara a consulta
$stmt = mysqli_prepare($conexao, $query);
if (!empty($pesquisa)) {
    // Adiciona os parâmetros de pesquisa com os curingas para busca parcial
    $pesquisa_param = '%' . $pesquisa . '%';
    mysqli_stmt_bind_param($stmt, 'ss', $pesquisa_param, $pesquisa_param);
}

// Executa a consulta
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verifica se existem resultados
if (mysqli_num_rows($result) > 0) {
    // Exibe os resultados da pesquisa
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                  <td class="nome_func">' . htmlspecialchars($row['nome']) . '</td>
                  <td>
                      <a href="gerente_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                      <a href="gerente_editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                      <a href="#" onclick="confirmarRemocao(' . $row['id'] . ')" id="remove">Remover</a>
                  </td>
              </tr>';
    }
} else {
    // Mensagem caso nenhum funcionário seja encontrado
    echo '<tr><td colspan="2">Nenhum funcionário encontrado.</td></tr>';
}

// Fecha a consulta
mysqli_stmt_close($stmt);
?>
