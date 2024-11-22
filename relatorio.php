<?php
session_start();
include './conexao.php'; // Conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_nome = $_SESSION['usuario_nome'];  // Nome do usuário logado

// Consultando o banco de dados para obter os dados do relatório
try {
    $sql = "
        SELECT f.NomeFornecedor, SUM(c.ValorTotal) AS TotalCompras
        FROM Fornecedores f
        LEFT JOIN Compra c ON f.IdFornecedor = c.IdFornecedor
        GROUP BY f.IdFornecedor
        ORDER BY TotalCompras DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $relatorio_compras = $stmt->fetchAll(PDO::FETCH_ASSOC); // Armazenando os resultados
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Compras - Zorp</title>
    <link rel="stylesheet" href="./dashboard.css">
</head>
<body>

<!-- Incluindo o cabeçalho -->
<?php include 'header.php'; ?>

<main id="relatorio" class="relatorio">
    <div class="container-relatorio">
        <h1>Relatório de Compras por Fornecedor</h1>
        <table border='1'>
            <tr>
                <th>Nome do Fornecedor</th>
                <th>Total de Compras</th>
            </tr>
            <?php foreach ($relatorio_compras as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['NomeFornecedor']); ?></td>
                <td>R$ <?php echo number_format($row['TotalCompras'], 2, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</main>

<!-- Incluindo o rodapé -->
<?php include 'footer.php'; ?>

</body>
</html>
