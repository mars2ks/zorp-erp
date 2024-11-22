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
    <title>Home - Zorp</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo $usuario_nome; ?>!</h1>
    <p>Você está logado!</p>

    <div>
        <h2>Sobre a Zorp</h2>
        <p>A Zorp é uma empresa inovadora, focada em soluções para...</p>  <!-- Informações sobre a empresa -->
    </div>

    <div>
        <h2>Módulos</h2>
        <ul>
            <li><a href="pesquisa.php">Pesquisa</a></li>
        </ul>
    </div>
</body>
</html>
