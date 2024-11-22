<?php
session_start();
include 'conexao.php'; // Conexão com o banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Lista as tabelas disponíveis para pesquisa
$tabelas = ["Funcionario", "Cargo", "Estoque"];  // Exemplo de tabelas

// Verifica se o usuário escolheu uma tabela para visualizar
if (isset($_GET['tabela'])) {
    $tabela = $_GET['tabela'];

    // Verifica se a tabela existe no banco de dados
    if (in_array($tabela, $tabelas)) {
        // Consulta os dados da tabela
        $sql = "SELECT * FROM $tabela";
        $result = $conn->query($sql);
    } else {
        echo "<script>alert('Tabela inválida!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pesquisa - Zorp</title>
</head>
<body>
    <h1>Pesquisa de Dados</h1>

    <form method="GET" action="pesquisa.php">
        <label for="tabela">Escolha uma tabela:</label>
        <select name="tabela" id="tabela" required>
            <option value="">Selecione...</option>
            <?php foreach ($tabelas as $tabela_option): ?>
                <option value="<?php echo $tabela_option; ?>" <?php echo isset($tabela) && $tabela == $tabela_option ? 'selected' : ''; ?>><?php echo $tabela_option; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Pesquisar</button>
    </form>

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <h2>Resultados da Tabela <?php echo $tabela; ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <?php
                    // Exibe os nomes das colunas
                    $columns = $result->fetch_fields();
                    foreach ($columns as $column) {
                        echo "<th>" . $column->name . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Exibe os dados das linhas
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $data) {
                        echo "<td>" . $data . "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php elseif (isset($tabela)): ?>
        <p>Nenhum dado encontrado na tabela <?php echo $tabela; ?>.</p>
    <?php endif; ?>

    <br>
    <a href="home.php">Voltar à Home</a>
</body>
</html>
