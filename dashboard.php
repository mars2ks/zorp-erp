<?php
session_start();
include './conexao.php'; // Conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_nome = $_SESSION['usuario_nome'];  // Nome do usuário logado
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Zorp</title>
    <link rel="stylesheet" href="./dashboard.css">
</head>
<body>
<header class="header">
    <ul>
        <!-- Botão para voltar para a página inicial -->
        <a href="logout.php">Logout</a>
        <li><a href="pesquisa.php">Pesquisa</a></li>
    </ul>
</header>

<!-- Início -->
<main id="inicio" class="inicio">
    <div class="container-inicio">
        <div class="conteudo-inicio" data-aos="fade-up" data-aos-duration="1000">
            <div class="titulo-inicio">
                <h1>Bem-vindo, <?php echo $usuario_nome; ?>!</h1>
                <h1 class="destaque-inicio">Você está logado!</h1>
            </div>
        </div>
    </div>
</main>
<!-- Fim Início -->

<!-- Skills -->
<section id="skills" class="skills">
    <div class="container-skills" data-aos="fade-up" data-aos-duration="1000">
        <div class="conteudo-skills">

            <a href="./relatorio.php" class="box-skills" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <h3>Relatório de Compras</h3>
                <p>Visualize o valor das compras realizadas por cada fornecedor.</p>
            </a>

            <a href="./produtos.php" class="box-skills" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <i class="bi bi-palette"></i>
                <h3>Busca e venda de produtos.</h3>
                <p>Recupere todas as vendas realizadas por um IdUsuario.</p>
            </a>

            <a href="./compras.php" class="box-skills" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
                <i class="bi bi-book"></i>
                <h3>Registro de Compras.</h3>
                <p>Inserir um novo registro em Compra e CompraProdutoFornecedor, garantindo que ambas as operações sejam concluídas.</p>
            </a>

        </div>
    </div>
</section>
<!-- Fim Skills -->

<footer class="footer" id="footer">
    <div class="container-footer">
        <div class="footer-column logo-column">
            <img src="assets/img/SUA-LOGO-AQUI.png" alt="">
        </div>
        <div class="footer-column menu-column">
            <nav class="footer-nav">
                <a href="#inicio">Início</a>
                <a href="#LOGIN">fazer login</a>
                <a href="#cadastro">Cadastrar</a>
                <a href="#contato">Contato</a>
            </nav>
        </div>
    </div>
    <div class="footer-column credits-column">
        <p>&copy; 2024 Todos os direitos reservados.</p>
        <p>Desenvolvido por ADM│Devs.</p>
    </div>
</footer>

</body>
</html>
