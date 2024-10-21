<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gerente Funcionário</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/gerente/funcionario.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <script src="js/gerente/validar_senha.js"></script>
    <script src="js/gerente/formatocpf.js"></script>
</head>

<body>
    <!--Nesta tela o gerente cadastra a conta do funcionário, edita e remove-->
    <header>
        <nav>
            <!--Menu para alterar as opções de tela-->
            <div class="list">
                <ul>
                    <li class="dropdown">
                        <a href="#"><i class="bi bi-list"></i></a>

                        <div class="dropdown-list">
                            <a href="gerente_menu_inicial.php">Menu Inicial</a>
                            <a href="gerente_planos.php">Planos e Assinaturas</a>
                            <a href="gerente_graficos.php">Gráficos</a>
                            <a href="gerente_func.php">Funcionários</a>
                            <a href="gerente_aluno.php">Alunos</a>
                            <a href="gerente_sobre_nos.php">Sobre Nós</a>
                            <a href="gerente_suporte.php">Ajuda e Suporte</a>
                            <a href="tela_inicio.html">Sair</a>
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
                            <a href="#">Perfil</a>
                            <a href="#">Endereço</a>
                            <a href="#">Tema</a>
                            <a href="#">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="userlist">
                <div class="userlist-header">
                    <div class="userlist-title">
                        <h1>Funcionários Cadastrados</h1>
                    </div>
                </div>
                <div class="userlist-table">
                    <table>
                        <tbody>
                            <!-- Preenchendo com os dados do funcionário vindo do banco de dados -->
                            <?php
                            include 'php/gerente/conexao.php';
                            $query = "SELECT id, nome, email FROM funcionario";
                            $result = mysqli_query($conexao, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                          <td>' . $row['nome'] . ' - ' . '</td>
                          <td>
                              <a href="gerente_detalhes.php?id=' . $row['id'] . '" id="details">Ver Detalhes</a> 
                              <a href="editar.php?id=' . $row['id'] . '" id="edit">Editar</a> 
                              <a href="remover.php?id=' . $row['id'] . '" id="remove">Remover</a>
                          </td>
                        </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form">
            <form action="php/gerente/editar.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>">
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $usuario['email']; ?>">
                <br>
                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>">
                <br>
                <label for="senha">Senha:</label>
                <input type="text" name="senha" value="<?php echo $usuario['senha']; ?>">
                <br>
                <label for="cargo">Cargo:</label>
                <input type="text" name="cargo" value="<?php echo $usuario['cargo']; ?>">
                <br>
                <label for="data_contrat">Data de Contrato:</label>
                <input type="text" name="data_contrat" value="<?php echo $usuario['data_contrat']; ?>">
                <br>
                <label for="genero">Genero:</label>
                <input type="text" name="genero" value="<?php echo $usuario['genero']; ?>">
                <br>
                
                <input type="submit" value="Atualizar Perfil">
            </form>
            </div>
        </div>
    </main>
</body>

</html>