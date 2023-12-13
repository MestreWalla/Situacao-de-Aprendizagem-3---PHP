<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../conectar.php');

// Verificar se o usuário está autenticado
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit();
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    $id = urldecode($_GET['delete']);

    if ($id) {
        $confirmacao = true; // ou qualquer lógica que você queira para a confirmação

        if ($confirmacao) {
            // Executar a consulta de exclusão usando declaração preparada
            $queryDelete = "DELETE FROM produtos WHERE id = ?";
            $stmtDelete = $conexao->prepare($queryDelete);

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmtDelete) {
                $stmtDelete->bind_param('i', $id);
                $stmtDelete->execute();

                if ($stmtDelete->affected_rows > 0) {
                    $stmtDelete->close();
                    header('Location: dashboardProdutos.php?delete_success=true');
                    exit();
                } else {
                    echo "Erro ao excluir o produto. Erro: " . $stmtDelete->error;
                }
            } else {
                echo "Erro na preparação da consulta de exclusão.";
            }
        } else {
            // Cancelar a exclusão
            echo "Exclusão cancelada pelo usuário.";
        }
    } else {
        echo "ID do produto inválido.";
    }
}

// Função para obter os detalhes de um produto pelo id
function obterProdutoPorId($conexao, $id)
{
    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");

    // Tratar erro na preparação da consulta
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();

    // Tratar erro na execução da consulta
    if ($stmt->errno) {
        die("Erro na execução da consulta: " . $stmt->error);
    }

    $resultado = $stmt->get_result();

    // Tratar erro ao obter o resultado da consulta
    if (!$resultado) {
        die("Erro ao obter resultado da consulta: " . $stmt->error);
    }

    $produto = $resultado->fetch_assoc();

    // Fechar o statement apenas se foi bem-sucedido
    $stmt->close();

    return $produto;
}

// Consulta para selecionar todos os registros da tabela "produtos"
$stmt = $conexao->prepare("SELECT * FROM produtos");
$stmt->execute();
$resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../styles/siderbar.css">
    <title>Lista de Produtos</title>
    <!-- Estilos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-left: 60px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            margin-right: 10px;
        }

        .edit-button {
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #0056b3;
        }

        .delete-button {
            background-color: #ff0000;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
<header class="Sidebar">
        <img src="../img/logo.png" alt="" class="logo" style="border-radius: 50%;">
        <div class="links">
            <img src="Img/Cliente.png" alt="">
            <a href="dashboardClientes.php">Clientes</a>
        </div>
        <div class="links">
            <img src="img/Produtos.png" alt="">
            <a href="dashboardProdutos.php">Produtos</a>
        </div>
        <div class="links">
            <img src="img/Carrinho.png" alt="">
            <a href="../carrinho.html">Carrinho</a>
        </div>
        <div class="links">
            <img src="../img/Database.png" alt="">
            <a href="../Criar DB/index.php">Banco de Dados</a>
        </div>
    </header>
    <h2 class="titulo">Lista de Produtos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Imagem do Produto</th>
            <th>Nome do Produto</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>tag1</th>
            <th>tag2</th>
            <th>tag3</th>
            <th>Ações</th>
        </tr>
        <?php
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['imgProduto'] . "</td>";
                echo "<td>" . $row['nomeProduto'] . "</td>";
                echo "<td>" . $row['descricao'] . "</td>";
                echo "<td>" . $row['preco'] . "</td>";
                echo "<td>" . $row['tag1'] . "</td>";
                echo "<td>" . $row['tag2'] . "</td>";
                echo "<td>" . $row['tag3'] . "</td>";
                echo "<td>
                <a class='edit-button' href='editar_Produto.php?id=" . urlencode($row['id']) . "'>Editar</a>
                <a class='delete-button' href='dashboard_Produtos.php?delete=" . $row['id'] . "' onclick='return confirmDelete(this)'>Excluir</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Nenhum registro encontrado.</td></tr>";
        }
        ?>
    </table>

    <!-- Script para confirmação de exclusão -->
    <script>
        function confirmDelete(link) {
            if (confirm("Tem certeza que deseja excluir este Produto?")) {
                window.location.href = link.href;
            }
            return false;
        }
    </script>
</body>

</html>
<?php
// Fechar a conexão com o banco de dados
// $conexao->close();
?>