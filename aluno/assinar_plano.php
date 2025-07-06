<?php
require_once '../php/cadastro_login/check_login_aluno.php';
require_once '../php/conexao.php';

$plano_id = isset($_GET['plano_id']) ? (int) $_GET['plano_id'] : 0;

// Busca detalhes do plano selecionado
$queryPlano = $conn->prepare("SELECT * FROM planos WHERE id = ?");
$queryPlano->bind_param("i", $plano_id);
$queryPlano->execute();
$plano = $queryPlano->get_result()->fetch_assoc();

if (!$plano) {
    echo "Plano não encontrado!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
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
<head>
    <meta charset="UTF-8">
    <title>Assinar Plano</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/aluno/assinatura.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <!--Quando clicar nesta opção tem que aparecer as academias que ele está matriculado no sistema e quando clicar na academia deverá mostrar os dados de quantas pessoas estão treinando e os planos assinados nesta academia. -->
    <?php include '../partials/header_aluno.php'; ?> <!-- Inclui o cabeçalho -->
    <main>
        <h2><?php echo htmlspecialchars($plano['nome']); ?></h2>
        <p>Descrição: <?php echo htmlspecialchars($plano['descricao']); ?></p>
        <p>Valor: R$ <?php echo number_format($plano['valor'], 2, ',', '.'); ?></p>
        <form action="../php/aluno/processar_assinatura.php" method="POST">
            <input type="hidden" name="plano_id" value="<?php echo $plano_id; ?>">
            <label for="metodo_pagamento">Método de Pagamento:</label>
            <select id="metodo_pagamento" name="metodo_pagamento" onchange="atualizarFormulario()" required>
                <option value="">Selecione...</option>
                <option value="Cartão de Crédito">Cartão de Crédito</option>
                <option value="Cartão de Débito">Cartão de Débito</option>
                <option value="Pix">Pix</option>
                <option value="Boleto">Boleto</option>
            </select>

            <div id="campos_cartao" style="display: none;">
                <label for="numero_cartao">Número do Cartão:</label>
                <input type="text" id="numero_cartao" name="numero_cartao" maxlength="20">

                <label for="nome_titular">Nome do Titular:</label>
                <input type="text" id="nome_titular" name="nome_titular">

                <label for="validade_cartao">Validade (MM/AAAA):</label>
                <input type="month" id="validade_cartao" name="validade_cartao">

                <label for="codigo_seguranca">Código de Segurança:</label>
                <input type="text" id="codigo_seguranca" name="codigo_seguranca" maxlength="4">

                <label for="cpf_titular">CPF do Titular:</label>
                <input type="text" id="cpf_titular" name="cpf_titular" maxlength="11">
            </div>

            <div id="campos_pix" style="display: none;">
                <p>Para pagamento via Pix, um QR Code será gerado após a confirmação.</p>
            </div>

            <div id="campos_boleto" style="display: none;">
                <p>Para pagamento via boleto, um código será gerado após a confirmação.</p>
            </div>

            <button type="submit">Confirmar Assinatura</button>
        </form>
        <a href="plano_academia.php?academia_id=<?php echo htmlspecialchars($plano['Academia_id']); ?>">Voltar</a>
    </main>
    <script>
        function atualizarFormulario() {
            const metodo = document.getElementById('metodo_pagamento').value;
            document.getElementById('campos_cartao').style.display = metodo.includes('Cartão') ? 'block' : 'none';
            document.getElementById('campos_pix').style.display = metodo === 'Pix' ? 'block' : 'none';
            document.getElementById('campos_boleto').style.display = metodo === 'Boleto' ? 'block' : 'none';
        }
    </script>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
</body>

</html>