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

// Função para excluir um usuário pelo e-mail
if (isset($_GET['delete'])) {
    $emailUsuario = urldecode($_GET['delete']);

    if ($emailUsuario) {
        $confirmacao = true; // ou qualquer lógica que você queira para a confirmação

        if ($confirmacao) {
            // Executar a consulta de exclusão usando declaração preparada
            $queryDelete = "DELETE FROM clientes WHERE email = ?";
            $stmtDelete = $conexao->prepare($queryDelete);

            // Verificar se a preparação da consulta foi bem-sucedida
            if ($stmtDelete) {
                $stmtDelete->bind_param('s', $emailUsuario);
                $stmtDelete->execute();

                if ($stmtDelete->affected_rows > 0) {
                    $stmtDelete->close();
                    header('Location: dashboardClientes.php?delete_success=true');
                    exit();
                } else {
                    echo "Erro ao excluir o usuário. Erro: " . $stmtDelete->error;
                }
            } else {
                echo "Erro na preparação da consulta de exclusão.";
            }
        } else {
            // Cancelar a exclusão
            echo "Exclusão cancelada pelo usuário.";
        }
    } else {
        echo "Email do usuário inválido.";
    }
}

// Função para obter os detalhes de um cliente pelo email
function obterClientePorEmail($conexao, $emailCliente)
{
    $stmt = $conexao->prepare("SELECT * FROM clientes WHERE email = ?");

    // Tratar erro na preparação da consulta
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conexao->error);
    }

    $stmt->bind_param('s', $emailCliente);
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

    $cliente = $resultado->fetch_assoc();

    // Fechar o statement apenas se foi bem-sucedido
    $stmt->close();

    return $cliente;
}

// Consulta para selecionar todos os registros da tabela "clientes"
$stmt = $conexao->prepare("SELECT * FROM clientes");
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../styles/siderbar.css">
    <title>Lista de Usuários</title>
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
        <img src="img/logo.png" alt="" class="logo">
        <div class="links">
            <img src="Img/home.png" alt="">
            <a href="dashboardClientes.php">Clientes</a>
        </div>
        <div class="links">
            <img src="img/java.png" alt="">
            <a href="Cadastros/cadastroProdutos.php">Cadastro de Produtos</a>
        </div>
        <div class="links">
            <img src="img/php.png" alt="">
            <a href="dashboardClientes.php">Loja</a>
        </div>
        <div class="links">
            <img src="img/swift.png" alt="">
            <a href="dashboardClientes.php">Carrinho</a>
        </div>
    </header>
    <h2 class="titulo">Lista de Usuários</h2>
    <table>
        <tr>
            <th>Admin</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Nascimento</th>
            <th>CPF</th>
            <th>Endereço</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php
        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . ($row['adm'] ? 'Sim' : 'Nao') . "</td>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['sobrenome'] . "</td>";
                echo "<td>" . $row['nascimento'] . "</td>";
                echo "<td>" . $row['cpf'] . "</td>";
                echo "<td>" . $row['rua'] . ", " . $row['n'] . " - " . $row['cep'] . " - " . $row['cidade'] . " - " . $row['uf'] . " - " . $row['complemento'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>
                <a class='edit-button' href='editar_usuario.php?email=" . urlencode($row['email']) . "'>Editar</a>
                <a class='delete-button' href='dashboardClientes.php?delete=" . urlencode($row['email']) . "' onclick='return confirmDelete(this)'>Excluir</a>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Nenhum registro encontrado.</td></tr>";
        }
        ?>
    </table>
</body>
<script>
    function confirmDelete(link) {
        if (confirm("Tem certeza que deseja excluir este cliente?")) {
            window.location.href = link.href;
        }
        return false;
    }
</script>

</html>

<?php
// Fechar a conexão com o banco de dados
// $conexao->close();
?>