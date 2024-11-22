<?php
session_start();
include './conexao.php'; // Conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para verificar se o usuário existe
    $stmt = $pdo->prepare('SELECT * FROM Usuario WHERE Email = :email AND Ativo = 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe e se a senha é correta
    if ($user && password_verify($senha, $user['Senha'])) {
        // Login bem-sucedido, inicia a sessão
        $_SESSION['usuario_id'] = $user['IdUsuario'];
        $_SESSION['usuario_email'] = $user['Email'];
        $_SESSION['usuario_tipo'] = $user['Tipo'];  // Tipo do usuário

        // Redireciona para a página do dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        // Se não encontrar o usuário ou a senha estiver errada
        echo '<script>alert("E-mail ou senha incorretos ou conta inativa!");</script>';
        echo '<script>window.location.href = "cadastro.php";</script>';
    }
}
?>
