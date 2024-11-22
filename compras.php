<?php
session_start();
include './conexao.php'; // Conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Recebendo os dados do formulário
$idFornecedor = $_POST['idFornecedor'];
$dataCompra = $_POST['dataCompra'];
$valorTotal = $_POST['valorTotal'];
$idProdutos = $_POST['idProduto'];
$quantidades = $_POST['quantidade'];
$precosUnitarios = $_POST['precoUnitario'];

try {
    // Inicia uma transação para garantir que todas as operações sejam realizadas
    $pdo->beginTransaction();

    // Inserindo a compra
    $sqlCompra = "INSERT INTO Compra (IdFornecedor, DataCompra, ValorTotal) VALUES (:idFornecedor, :dataCompra, :valorTotal)";
    $stmtCompra = $pdo->prepare($sqlCompra);
    $stmtCompra->execute([
        ':idFornecedor' => $idFornecedor,
        ':dataCompra' => $dataCompra,
        ':valorTotal' => $valorTotal
    ]);

    // Pegando o ID da compra recém inserida
    $idCompra = $pdo->lastInsertId();

    // Inserindo os produtos associados à compra
    for ($i = 0; $i < count($idProdutos); $i++) {
        $sqlProduto = "INSERT INTO CompraProdutoFornecedor (IdCompra, IdProduto, Quantidade, PrecoUnitario) 
                        VALUES (:idCompra, :idProduto, :quantidade, :precoUnitario)";
        $stmtProduto = $pdo->prepare($sqlProduto);
        $stmtProduto->execute([
            ':idCompra' => $idCompra,
            ':idProduto' => $idProdutos[$i],
            ':quantidade' => $quantidades[$i],
            ':precoUnitario' => $precosUnitarios[$i]
        ]);
    }

    // Se tudo ocorrer corretamente, confirma a transação
    $pdo->commit();

    echo "Compra registrada com sucesso!";
} catch (PDOException $e) {
    // Em caso de erro, faz o rollback da transação
    $pdo->rollBack();
    echo "Erro ao registrar a compra: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Compra</title>
</head>
<body>

<h1>Registrar Nova Compra</h1>
<form action="processar_registro_compra.php" method="post">
    <label for="idFornecedor">ID do Fornecedor:</label>
    <input type="number" id="idFornecedor" name="idFornecedor" required>

    <label for="dataCompra">Data da Compra:</label>
    <input type="date" id="dataCompra" name="dataCompra" required>

    <label for="valorTotal">Valor Total:</label>
    <input type="number" id="valorTotal" name="valorTotal" step="0.01" required>

    <h3>Produtos</h3>
    <div id="produtos">
        <div class="produto" id="produto1">
            <label for="idProduto1">ID do Produto:</label>
            <input type="number" id="idProduto1" name="idProduto[]" required>
            
            <label for="quantidade1">Quantidade:</label>
            <input type="number" id="quantidade1" name="quantidade[]" required>
            
            <label for="precoUnitario1">Preço Unitário:</label>
            <input type="number" id="precoUnitario1" name="precoUnitario[]" step="0.01" required>
        </div>
    </div>
    
    <button type="button" onclick="adicionarProduto()">Adicionar Produto</button>
    <button type="submit">Registrar Compra</button>
</form>

<script>
    let contador = 1;

    function adicionarProduto() {
        contador++;
        const produtosDiv = document.getElementById('produtos');
        const novoProduto = `
            <div class="produto" id="produto${contador}">
                <label for="idProduto${contador}">ID do Produto:</label>
                <input type="number" id="idProduto${contador}" name="idProduto[]" required>
                
                <label for="quantidade${contador}">Quantidade:</label>
                <input type="number" id="quantidade${contador}" name="quantidade[]" required>
                
                <label for="precoUnitario${contador}">Preço Unitário:</label>
                <input type="number" id="precoUnitario${contador}" name="precoUnitario[]" step="0.01" required>
            </div>
        `;
        produtosDiv.insertAdjacentHTML('beforeend', novoProduto);
    }
</script>

</body>
</html>
