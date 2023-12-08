<?php
session_start();
include('conectar.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Use uma consulta preparada para evitar injeção de SQL
    $query = "SELECT senha FROM clientes WHERE email = ?";
    $stmt = mysqli_prepare($conexao, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && $row = mysqli_fetch_assoc($resultado)) {
            // Verifique se a senha está correta usando password_verify
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['email'] = $email;
                header('Location: ./Dashboard/dashboardClientes.php');
                exit();
            } else {
                $erro = 'Credenciais inválidas. Tente novamente.';
            }
        } else {
            $erro = 'Credenciais inválidas. Tente novamente.';
        }

        mysqli_stmt_close($stmt);
    } else {
        // Possível registro de erro em log
        $erro = 'Erro na preparação da consulta de login.';
    }
}

// Feche a conexão com o banco de dados (pode não ser necessário dependendo do restante do seu código)
// mysqli_close($conexao);
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/root.css">
    <link rel="stylesheet" href="styles/header.css">
    <title>Página de Login</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="button"] {
            background-color: #ff9500;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 5px;
        }

        input[type="button"]:hover {
            background-color: #b36800;
        }

        p.error-message {
            color: #ff0000;
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
            <a href="http://localhost/php/Maycon%20PHP/siteTeste/login.php"><button class="logar" id="logar">
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

    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($erro)): ?>
            <p class="error-message">Credenciais inválidas. Tente novamente.</p>
        <?php endif; ?>
        <form method="post">
            <label for="email">Email:</label> <!-- Alterado de 'usuario' para 'email' -->
            <input type="text" id="email" name="email" required> <!-- Alterado de 'usuario' para 'email' -->

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <input type="submit" value="Login">
            <a href="Cadastros/cadastroClientes.php"><input type="button" value="Cadastro"></a>
        </form>
    </div>
</body>

</html>