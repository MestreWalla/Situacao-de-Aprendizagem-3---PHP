<?php
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validação dos dados do formulário
    $nomeProduto = isset($_POST['nomeProduto']) ? $_POST['nomeProduto'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : '';
    $tag1 = isset($_POST['tag1']) ? $_POST['tag1'] : '';
    $tag2 = isset($_POST['tag2']) ? $_POST['tag2'] : '';
    $tag3 = isset($_POST['tag3']) ? $_POST['tag3'] : '';

    // Verifica se os campos obrigatórios foram preenchidos
    if (empty($nomeProduto) || empty($descricao) || empty($preco) || empty($tag1)) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else {
        // Verifica se um arquivo de imagem foi enviado
        if (isset($_FILES['imgProduto']) && $_FILES['imgProduto']['error'] === UPLOAD_ERR_OK) {
            $nomeArquivo = $_FILES['imgProduto']['name'];
            $caminhoTemp = $_FILES['imgProduto']['tmp_name'];
            $caminhoDestino = 'imgProdutos/' . $nomeArquivo; // Pasta onde será salvo

            // Move o arquivo enviado para o diretório desejado
            if (move_uploaded_file($caminhoTemp, $caminhoDestino)) {
                // Configurações de conexão com o banco de dados
                $host = 'localhost';
                $dbusuario = 'root';
                $dbSenha = '';
                $dbname = 'sa3pwfe';

                // Conexão com o banco de dados
                $conexao = new mysqli($host, $dbusuario, $dbSenha, $dbname);

                if ($conexao->connect_error) {
                    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
                }

                // Query SQL para inserção de dados
                $query = "INSERT INTO produtos (id, imgProduto, nomeProduto, descricao, preco, tag1, tag2, tag3) 
                          VALUES (null, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conexao->prepare($query);

                if ($stmt === false) {
                    $erro = 'Erro na preparação da consulta: ' . $conexao->error;
                } else {
                    $stmt->bind_param('sssssss', $caminhoDestino, $nomeProduto, $descricao, $preco, $tag1, $tag2, $tag3);

                    if ($stmt->execute()) {
                        echo "Cadastro concluído";
                        header('Location: cadastroProdutos.php');
                        exit();
                    } else {
                        $erro = 'Erro ao executar a consulta: ' . $stmt->error;
                    }
                }

                $conexao->close();
            } else {
                $erro = 'Erro ao mover o arquivo para o diretório de destino.';
            }
        } else {
            $erro = 'Nenhum arquivo de imagem foi enviado.';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../styles/siderbar.css">
    <title>Página de Cadastro de Produto</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            /* margin-top: 200px; */
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 100vh; */
        }

        .cadastro-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
        }

        h2 {
            text-align: center;
            font-size: 40px;
        }

        p {
            text-align: center;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        form div {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 300px;

            & p {
                transform: translateX(-15px);
            }
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            margin: 0 10px;
            padding: 10px;
            transform: translateY(1.8px);
            background-color: white;
            width: min-content;
            height: 0px;
        }

        input {
            width: 250px;
        }

        input[type="file"] {
            height: 16px;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;

            &:hover {
                border-color: #007bff;
            }
        }

        input:focus {
            border-color: red;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 270px;
            transform: translateY(-10px);
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Estilo para o botão personalizado */
        .custom-file-input input {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
        }

        /* Estilo para a aparência do botão personalizado */
        .custom-file-input label {
            padding: 10px 20px;
            margin: 0;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 230px;
            height: 15px;
            text-align: center;
            transform: translateY(20px);

            &:hover {
                background-color: #0056b3;
            }
        }

        .error-message {
            color: red;
            text-align: center;
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
    <div class="cadastro-container">
        <h2>Cadastro</h2>
        <p>Preencha os campos com cuidado</p>

        <?php if (isset($erro)) {
            echo '<p class="error-message">' . $erro . '</p>';
        } ?>

        <form method="post" enctype="multipart/form-data">
            <div class="custom-file-input">
                <label for="imgProduto">Imagem do produto</label>
                <input type="file" id="imgProduto" name="imgProduto" multiple>
            </div>
            <div>
                <label for="nomeProduto">Nome_do_Produto:</label>
                <input type="text" id="nomeProduto" name="nomeProduto">
            </div>
            <div>
                <label for="descricao">descricao:</label>
                <input type="text" id="descricao" name="descricao">
            </div>
            <div>
                <label for="preco">preco:</label>
                <input type="text" id="preco" name="preco">
            </div>
            <div>
                <label for="tag1">tag1:</label>
                <input type="text" id="tag1" name="tag1">
            </div>
            <div>
                <label for="tag2">tag2:</label>
                <input type="text" id="tag2" name="tag2">
            </div>
            <div>
                <label for="tag3">tag3:</label>
                <input type="text" id="tag3" name="tag3" required>
            </div>
            <div>
                <label for="botao"></label>
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>

</html>