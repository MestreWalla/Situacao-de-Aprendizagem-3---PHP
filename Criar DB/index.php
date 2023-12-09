<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Banco de Dados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }
        form div {
            display: flex;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            display: flex;
            align-items: center;
            width: 200px;
            border-radius: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        button img {
            height: 30px;
            margin-right: 30px;
        }

        .delete-button {
            background-color: #ff6347;
            width: 70px;
        }

        .delete-button:hover {
            background-color: #b84632;
        }

        .tables-section {
            margin-top: 40px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <h1>Gerenciamento de Banco de Dados</h1>

    <form action="" method="post">
        <div>
            <button type="submit" name="create_database"><img src="img/Database.png" alt="">Criar Banco de
                Dados</button>
            <button type="submit" name="delete_database" class="delete-button"><img src="img/Delete.png" alt=""></button>
        </div>
        <div>
            <button type="submit" name="create_table_carrinho"><img src="img/Carrinho.png" alt="">Criar Tabela
                Carrinho</button>
            <button type="submit" name="delete_table_carrinho" class="delete-button"><img src="img/Delete.png"
                    alt=""></button>
        </div>
        <div>
            <button type="submit" name="create_table_clientes"><img src="img/Cadastro.png" alt="">Criar Tabela
                Clientes</button>
            <button type="submit" name="delete_table_clientes" class="delete-button"><img src="img/Delete.png"
                    alt=""></button>
        </div>
        <div>
            <button type="submit" name="create_table_produtos"><img src="img/Produto.png" alt="">Criar Tabela
                Produtos</button>
            <button type="submit" name="delete_table_produtos" class="delete-button"><img src="img/Delete.png"
                    alt=""></button>
        </div>

    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["create_database"])) {
            include("criarDB.php");
        } elseif (isset($_POST["delete_database"])) {
            include("apagarDB.php");
        } elseif (isset($_POST["create_table_carrinho"])) {
            include("criarTabelaCarrinho.php");
        } elseif (isset($_POST["delete_table_carrinho"])) {
            include("apagarTabelaCarrinho.php");
        } elseif (isset($_POST["create_table_clientes"])) {
            include("criarTabelaClientes.php");
        } elseif (isset($_POST["delete_table_clientes"])) {
            include("apagarTabelaClientes.php");
        } elseif (isset($_POST["create_table_produtos"])) {
            include("criarTabelaProdutos.php");
        } elseif (isset($_POST["delete_table_produtos"])) {
            include("apagarTabelaProdutos.php");
        }
    }
    ?>
    <?php
    // Código para exibir as tabelas
    try {
        $conn = new PDO("mysql:host=127.0.0.1;dbname=sa3pwfe", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $result = $conn->query("SHOW TABLES");
        $tables = $result->fetchAll(PDO::FETCH_COLUMN);

        echo '<div class="tables-section">';
        echo '<h2>Tabelas no Banco de Dados</h2>';
        echo '<table>';
        echo '<tr><th>Nome da Tabela</th></tr>';

        foreach ($tables as $table) {
            echo "<tr><td>$table</td></tr>";
        }

        echo '</table>';
        echo '</div>';
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
    ?>
</body>

</html>