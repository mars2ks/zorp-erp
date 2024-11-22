<?php
// Conexão com o banco de dados
try {
    $host = 'localhost';
    $user = 'root';
    $pass = 'root';
    $db = 'zorp3r';
    $port = '3306';

    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $vendas = [];
    $mensagem = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_usuario'])) {
        $idUsuario = $_POST['id_usuario'];

        // Consulta para buscar as vendas do usuário
        $sqlVendas = "SELECT IdVenda, DataVenda, ValorTotal 
                      FROM Venda 
                      WHERE IdUsuario = :idUsuario 
                      ORDER BY DataVenda DESC";
        $stmtVendas = $pdo->prepare($sqlVendas);
        $stmtVendas->bindParam(':idUsuario', $idUsuario);
        $stmtVendas->execute();

        $vendas = $stmtVendas->fetchAll(PDO::FETCH_ASSOC);

        if (empty($vendas)) {
            $mensagem = "Nenhuma venda encontrada para o usuário com ID: $idUsuario.";
        }
    }
} catch (PDOException $e) {
    $mensagem = "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca e Venda de Produtos</title>
</head>
<body>
    <h1>Buscar Vendas por Usuário</h1>

    <form action="pagina2.php" method="post">
        <label for="id_usuario">ID do Usuário:</label>
        <input type="number" id="id_usuario" name="id_usuario" required><br><br>

        <input type="submit" value="Buscar Vendas">
    </form>

    <?php if (isset($vendas) && !empty($vendas)): ?>
        <h2>Vendas Encontradas:</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Venda</th>
                    <th>Data da Venda</th>
                    <th>Valor Total</th>
                    <th>Produtos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($venda['IdVenda']); ?></td>
                        <td><?php echo htmlspecialchars($venda['DataVenda']); ?></td>
                        <td><?php echo 'R$ ' . number_format($venda['ValorTotal'], 2, ',', '.'); ?></td>
                        <td>
                            <?php
                                // Busca os produtos da venda atual
                                $sqlProdutos = "SELECT p.NomeProduto, cp.Quantidade, cp.PrecoUnitario 
                                                FROM CompraProdutoFornecedor cp
                                                JOIN Produto p ON cp.IdProduto = p.IdProduto
                                                WHERE cp.IdVenda = :idVenda";
                                $stmtProdutos = $pdo->prepare($sqlProdutos);
                                $stmtProdutos->bindParam(':idVenda', $venda['IdVenda']);
                                $stmtProdutos->execute();
                                $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

                                // Exibe os produtos dessa venda
                                foreach ($produtos as $produto) {
                                    echo $produto['NomeProduto'] . " - Quantidade: " . $produto['Quantidade'] . " - Preço Unitário: R$ " . number_format($produto['PrecoUnitario'], 2, ',', '.') . "<br>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
