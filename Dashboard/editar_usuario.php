<?php
session_start();
include('conectar.php');
include('dashboardClientes.php');

if (isset($_GET['email'])) {
    $emailCliente = urldecode($_GET['email']);
    $cliente = obterClientePorEmail($conexao, $emailCliente);

    if ($cliente) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Usuário</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                }

                input {
                    display: block;
                    margin-bottom: 10px;
                }

                .salvar {
                    background-color: #007bff;
                    color: #fff;
                    padding: 5px 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .salvar:hover {
                    background-color: #0056b3;
                }

                .cancelar {
                    background-color: #ff0000;
                    color: #fff;
                    padding: 5px 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .cancelar:hover {
                    background-color: #cc0000;
                }
            </style>
        </head>

        <body>
            <h2 class="titulo">Editar Usuário</h2>
            <form action="processar_edicao.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th>Admin</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Nascimento</th>
                        <th>CPF</th>
                        <th>Endereço</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                    <td><input type="checkbox" name="adm" <?= $cliente['adm'] ? 'checked' : '' ?>></td>
                    <td><input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required></td>
                    <td><input type="text" name="sobrenome" value="<?= htmlspecialchars($cliente['sobrenome']) ?>" required>
                    </td>
                    <td><input type="text" name="nascimento" value="<?= htmlspecialchars($cliente['nascimento']) ?>" required>
                    </td>
                    <td><input type="text" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>" required></td>
                    <td>
                        <input type="text" name="rua" value="<?= htmlspecialchars($cliente['rua']) ?>" required>
                        <input type="text" name="n" value="<?= htmlspecialchars($cliente['n']) ?>" required>
                        <input type="text" name="cep" value="<?= htmlspecialchars($cliente['cep']) ?>" required>
                        <input type="text" name="cidade" value="<?= htmlspecialchars($cliente['cidade']) ?>" required>
                        <input type="text" name="uf" value="<?= htmlspecialchars($cliente['uf']) ?>" required>
                        <input type="text" name="complemento" value="<?= htmlspecialchars($cliente['complemento']) ?>" required>
                    </td>
                    <td><input type="text" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required></td>
                    <td style="display: flex; gap: 10px;">
                        <input type="submit" value="Salvar" class="salvar">
                        <a href="http://localhost/php/Maycon%20PHP/SA3PWFE/dashboardClientes.php">
                            <input type="button" value="Cancelar" class="cancelar">
                        </a>
                    </td>
                </table>
            </form>
            <script>
                function confirmarCancelar() {
                    if (confirm("Tem certeza que deseja cancelar a edição?")) {
                        window.location.href = 'dashboardClientes.php';
                    }
                    return false;
                }
            </script>
        </body>

        </html>
        <?php
    } else {
        echo "Cliente não encontrado.";
    }
} else {
    echo "E-mail do cliente não fornecido.";
}
?>