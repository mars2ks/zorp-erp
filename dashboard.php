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
    <link rel="stylesheet" href="./responsividade.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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

<!-- Skills --><section id="skills" class="skills">
    <div class="container-skills" data-aos="fade-up" data-aos-duration="1000">
        <div class="conteudo-skills">

            <!-- Card 1: Relatório de Compras -->
            <div class="box-skills" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <a href="./relatorio.php">
                    <i class="bi bi-file-earmark-bar-graph"></i> <!-- Ícone de gráfico de barras para Relatório -->
                    <h3>Relatório de Compras.</h3>
                </a>
                <p>Visualize o valor das compras realizadas por cada fornecedor.</p>
            </div>

            <!-- Card 2: Busca e venda de produtos -->
            <div class="box-skills" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <a href="./produtos.php">
                    <i class="bi bi-search"></i> <!-- Ícone de pesquisa -->
                    <h3>Busca e venda de produtos.</h3>
                </a>
                <p>Recupere todas as vendas realizadas por um IdUsuario.</p>
            </div>

            <!-- Card 3: Registro de Compras -->
            <div class="box-skills" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                <a href="./compras.php">
                    <i class="bi bi-cart-plus"></i> <!-- Ícone de adicionar ao carrinho -->
                    <h3>Registro de Compras.</h3>
                </a>
                <p>Inserir um novo registro em Compra e CompraProdutoFornecedor, garantindo que ambas as operações sejam concluídas.</p>
            </div>
            
        </div>
    </div>
</section>
<!-- Fim Skill -->

<!-- Fim Skill -->


<footer class="footer" id="footer">
    <div class="footer-column credits-column">
        <p>&copy; 2024 Todos os direitos reservados.</p>
        <p>Desenvolvido por ADM│Devs.</p>
    </div>
</footer>

</body>
</html>
