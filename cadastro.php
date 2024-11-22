<?php
session_start();

// Incluindo a conexão com o banco de dados
include './conexao.php'; // Verifique se o caminho está correto

// Inicializar a variável mensagem
$mensagem = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegar os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validar os dados
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        $mensagem = 'Por favor, preencha todos os campos.';
    } elseif ($senha !== $confirmar_senha) {
        $mensagem = 'As senhas não coincidem.';
    } else {
        // Sanitizar o e-mail para evitar problemas de segurança
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Verificar se o e-mail já está cadastrado
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql); // Certifique-se que $conn está sendo inicializada corretamente
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $mensagem = 'Este e-mail já está registrado.';
        } else {
            // Inserir os dados do novo usuário no banco de dados
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Criptografar a senha

            $sql_insert = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('sss', $nome, $email, $senha_hash);

            if ($stmt_insert->execute()) {
                $mensagem = 'Cadastro realizado com sucesso!';
                // Redireciona para outra página após cadastro (exemplo: login)
                header("Location: login.php");
                exit();
            } else {
                $mensagem = 'Erro ao cadastrar. Tente novamente.';
            }
        }
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
