<?php
session_start();
include('../Cadastros/conectar.php');
include('dashboardProdutos.php');

if(isset($_GET['id'])) {
    $id = urldecode($_GET['id']);
    $produto = obterProdutoPorId($conexao, $id);

    if($produto) {
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
            <h2>Editar Usuário</h2>
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
                    <td><input type="checkbox" name="adm" <?= $produto['adm'] ? 'checked' : '' ?>></td>
                    <td><input type="text" name="id" value="<?= htmlspecialchars($produto['id']) ?>" required></td>
                    <td><input type="text" name="imgProduto" value="<?= htmlspecialchars($produto['imgProduto']) ?>" required>
                    </td>
                    <td><input type="text" name="nomeProduto" value="<?= htmlspecialchars($produto['nomeProduto']) ?>" required>
                    </td>
                    <td><input type="text" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>" required></td>
                    <td>
                        <input type="text" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
                        <input type="text" name="tag1" value="<?= htmlspecialchars($produto['tag1']) ?>" required>
                        <input type="text" name="tag2" value="<?= htmlspecialchars($produto['tag2']) ?>" required>
                        <input type="text" name="tag3" value="<?= htmlspecialchars($produto['tag3']) ?>" required>
                    </td>
                    <td><input type="text" name="id" value="<?= htmlspecialchars($produto['id']) ?>" required></td>
                    <td style="display: flex; gap: 10px;">
                        <input type="submit" value="Salvar" class="salvar">
                        <a href="http://localhost/php/Situacao-de-Aprendizagem-3---LMR/php/Dashboard/dashboardProdutos.php">
                            <input type="button" value="Cancelar" class="cancelar">
                        </a>
                    </td>
                </table>
            </form>
            <script>
                function confirmarCancelar() {
                    if (confirm("Tem certeza que deseja cancelar a edição?")) {
                        window.location.href = 'dashboardProdutos.php';
                    }
                    return false;
                }
            </script>
        </body>

        </html>
        <?php
    } else {
        echo "Produto não encontrado.";
    }
} else {
    echo "Id do produto não fornecido.";
}
?>