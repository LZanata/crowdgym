<?php
require_once 'php/cadastro_login/check_login_aluno.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajuda e Suporte</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/aluno/suporte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
</head>
<body>
    <header>
        <!-- Quando clicar aparecerá a tela para enviar uma mensagem ou tickets para o suporte técnico -->
        <nav>
            <!-- Menu para alterar as opções de tela -->
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
            <div class="logo">
                <h1>Crowd Gym</h1>
            </div>
            <div class="user">
                <ul>
                    <li class="user-icon">
                        <a href="#"><i class="bi bi-person-circle"></i></a>
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
        <section class="support-section">
            <h2>Ajuda e Suporte</h2>
            <p>Preencha o formulário abaixo para abrir um ticket de suporte. Nossa equipe entrará em contato em breve.</p>
            
            <form action="enviar_ticket.php" method="POST" class="support-form">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required placeholder="Digite seu nome">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Digite seu e-mail">

                <label for="mensagem">Descrição do Problema:</label>
                <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Descreva o problema"></textarea>

                <button type="submit" class="submit-btn">Enviar Ticket</button>
            </form>
        </section>
    </main>

    <footer>
        <div id="footer_copyright">
            &#169; 2024 CROWD GYM FROM EASY SYSTEM LTDA
        </div>
    </footer>
</body>
</html>