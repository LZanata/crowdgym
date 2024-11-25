<?php
require_once '../php/cadastro_login/check_login_aluno.php';
require_once '../php/conexao.php';

$plano_id = isset($_GET['plano_id']) ? (int) $_GET['plano_id'] : 0;

// Busca detalhes do plano selecionado
$queryPlano = $conexao->prepare("SELECT * FROM planos WHERE id = ?");
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

<head>
    <meta charset="UTF-8">
    <title>Assinar Plano</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/aluno/assinatura.css">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>

<body>
    <header>
        <!--Quando clicar nesta opção tem que aparecer as academias que ele está matriculado no sistema e quando clicar na academia deverá mostrar os dados de quantas pessoas estão treinando e os planos assinados nesta academia. -->
        <nav>
            <!--Menu para alterar as opções de tela-->
            <div class="list">
                <ul>
                    <li class="dropdown">
                        <a href="#"><i class="bi bi-list"></i></a>

                        <div class="dropdown-list">
                            <a href="aluno_menu_inicial.php">Menu Inicial</a>
                            <a href="aluno_minhas_academias.php">Minhas Academias</a>
                            <a href="aluno_buscar_academias.php">Buscar Academias</a>
                            <a href="aluno_dados_pagamento.php">Dados de Pagamento</a>
                            <a href="aluno_sobre_nos.php">Sobre Nós</a>
                            <a href="aluno_suporte.php">Ajuda e Suporte</a>
                            <a href="php/cadastro_login/logout.php">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!--Logo do Crowd Gym(quando passar o mouse por cima, o logo devera ficar laranja)-->
            <div class="logo">
                <h1>Crowd Gym</h1>
            </div>
            <!--Opção para alterar as configurações de usuário-->
            <div class="user">
                <ul>
                    <li class="user-icon">
                        <a href=""><i class="bi bi-person-circle"></i></a>

                        <div class="dropdown-icon">
                            <a href="#">Editar Perfil</a>
                            <a href="#">Alterar Tema</a>
                            <a href="#">Sair da Conta</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <h2><?php echo htmlspecialchars($plano['nome']); ?></h2>
        <p>Descrição: <?php echo htmlspecialchars($plano['descricao']); ?></p>
        <p>Valor: R$ <?php echo number_format($plano['valor'], 2, ',', '.'); ?></p>
        <form action="php/aluno/processar_assinatura.php" method="POST">
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
        <a href="aluno_plano_academia.php?academia_id=<?php echo htmlspecialchars($plano['Academia_id']); ?>">Voltar</a>
    </main>
    <?php include '../partials/footer.php'; ?> <!-- Inclui o rodapé -->
    <script>
        function atualizarFormulario() {
            const metodo = document.getElementById('metodo_pagamento').value;
            document.getElementById('campos_cartao').style.display = metodo.includes('Cartão') ? 'block' : 'none';
            document.getElementById('campos_pix').style.display = metodo === 'Pix' ? 'block' : 'none';
            document.getElementById('campos_boleto').style.display = metodo === 'Boleto' ? 'block' : 'none';
        }
    </script>
</body>

</html>