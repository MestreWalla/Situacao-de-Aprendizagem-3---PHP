<?php
$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Valide os dados do formulário
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
    $confirmaSenha = isset($_POST['confirmaSenha']) ? $_POST['confirmaSenha'] : '';
    $img = isset($_POST['img']) ? $_POST['img'] : '';
    $nascimento = isset($_POST['nascimento']) ? $_POST['nascimento'] : '';
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';
    $rua = isset($_POST['rua']) ? $_POST['rua'] : '';
    $n = isset($_POST['n']) ? $_POST['n'] : '';
    $complemento = isset($_POST['complemento']) ? $_POST['complemento'] : '';
    $cidade = isset($_POST['cidade']) ? $_POST['cidade'] : '';
    $uf = isset($_POST['uf']) ? $_POST['uf'] : '';
    $cep = isset($_POST['cep']) ? $_POST['cep'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Verifica se as senhas coincidem
    if ($senha !== $confirmaSenha) {
        $erro = 'As senhas não coincidem.';
    } else {
        session_start();
        include('../conectar.php');

        if ($conexao->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
        }

        // Verifica se o email já existe no banco de dados
        $verificarEmail = "SELECT email FROM clientes WHERE email = ?";
        $stmtVerificar = $conexao->prepare($verificarEmail);
        $stmtVerificar->bind_param('s', $email);
        $stmtVerificar->execute();
        $stmtVerificar->store_result();

        if ($stmtVerificar->num_rows > 0) {
            $erro = 'Este email já está cadastrado. Por favor, escolha outro.';
        } else {
            // Query SQL para inserção de dados
            $query = "INSERT INTO clientes (img, adm, nome, sobrenome, nascimento, cpf, rua, n, complemento, cidade, uf, cep, email, senha, usuario) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conexao->prepare($query);

            // Definindo usuario como não administrador por padrao
            $adm = 0;

            // Hash da senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Ajuste da string de definição de tipo e vinculação
            $stmt->bind_param('ssssssssssssssb', $img, $adm, $nome, $sobrenome, $nascimento, $cpf, $rua, $n, $complemento, $cidade, $uf, $cep, $email, $senhaHash, $sobrenome);

            if ($stmt->execute()) {
                // Cadastro bem-sucedido
                header('Location: ../login.php'); // Redirecionar para a página de login
                exit();
            } else {
                $erro = 'Erro ao cadastrar. Tente novamente.';
            }
        }

        // Fechar a conexão com o banco de dados
        $conexao->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../styles/root.css">
    <link rel="stylesheet" href="../styles/header.css">
    <title>Página de Cadastro</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            margin-top: 200px;
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

        input[type="text"],
        input[type="password"] {
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

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="menu01">
            <img src="img/logo.png" alt="Logo">
            <div class="buscar">
                <input type="PESQUISAR" placeholder="BUSCAR">
                <img src="img/lupa.png" alt="">
            </div>
            <a href="http://localhost/php/Maycon%20PHP/SA3PWFE/login.php"><button class="logar" id="logar">
                    <img src="img/user.png" alt="">
                    <p>Entre ou Cadastre-se</p>
                </button></a>

        </div>
        <div class="menu02">
            <a href="index.html" class="menuItem" id="menuItem">
                <img src="img/cao01.png" alt="">
                <h5>Inicio</h5>
            </a>
            <a href="loja.html" class="menuItem" id="menuItem">
                <img src="img/cao02.png" alt="">
                <h5>Loja</h5>
            </a>
            <a href="serviços.html" class="menuItem" id="menuItem">
                <img src="img/cao03.png" alt="">
                <h5>Serviços</h5>
            </a>
            <a href="sobre.html" class="menuItem" id="menuItem">
                <img src="img/cao04.png" alt="">
                <h5>Sobre</h5>
            </a>
    </header>
    <div class="cadastro-container">
        <h2>Cadastro</h2>
        <p>Preencha os campos com cuidado</p>

        <?php if (isset($erro)) {
            echo '<p class="error-message">' . $erro . '</p>';
        } ?>

        <form method="post">
            <div>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div>
                <label for="sobrenome">Sobrenome:</label>
                <input type="text" id="sobrenome" name="sobrenome" required>
            </div>
            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div>
                <label for="confirmaSenha">Confirmar_Senha:</label>
                <input type="password" id="confirmaSenha" name="confirmaSenha" required>
            </div>
            <div>
                <label for="img">Imagem:</label>
                <input type="text" id="img" name="img">
            </div>
            <div>
                <label for="nascimento">Nascimento:</label>
                <input type="text" id="nascimento" name="nascimento">
            </div>
            <div>
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf">
            </div>
            <div>
                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua">
            </div>
            <div>
                <label for="n">Nº:</label>
                <input type="text" id="n" name="n">
            </div>
            <div>
                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento">
            </div>
            <div>
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade">
            </div>
            <div>
                <label for="uf">UF:</label>
                <input type="text" id="uf" name="uf">
            </div>
            <div>
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div>
                <p>Já possui cadastro?
                    <a href="../login.php">Clique aqui</a>
                </p>
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>

</html>