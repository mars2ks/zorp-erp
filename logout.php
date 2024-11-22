<?php
session_start();  // Inicia a sessão
session_unset();  // Desfaz todas as variáveis de sessão
session_destroy();  // Destroi a sessão

// Redireciona para a página inicial
header("Location: index.html");
exit();  // Encerra a execução do script
?>
