<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/loja.css">
    <link rel="stylesheet" href="styles/root.css">
    <title>Situalção de Aprendisagem 03</title>
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
            <a href="http://localhost/php/Maycon%20PHP/Situacao-de-Aprendizagem-3---PHP/login.php"><button class="logar" id="logar">
                    <img src="img/user.png" alt="">
                    <p>Entre ou Cadastre-se</p>
                </button></a>
                <button class="hamburguer" onclick="toggleMobileMenu()"><img src="img/hamburguer.png" alt=""></button>
                <div class="mobile">
                <a href="PRINCIPAL.html" class="linkMobile">Inicio</a>
                <a href="http://localhost/php/Maycon%20PHP/Situacao-de-Aprendizagem-3---PHP/loja.php" class="linkMobile">Loja</a>
                <a href="serviços.html" class="linkMobile">Serviços</a>
                <a href="sobre.html" class="linkMobile">Sobre</a>
                <a href="http://localhost/php/Maycon%20PHP/Situacao-de-Aprendizagem-3---PHP/login.php" class="linkMobile">Login</a>
            </div>
        </div>
        <div class="menu02">
            <a href="PRINCIPAL.html" class="menuItem" id="menuItem">
                <img src="img/cao01.png" alt="">
                <h5>Inicio</h5>
            </a>
            <a href="http://localhost/php/Maycon%20PHP/Situacao-de-Aprendizagem-3---PHP/loja.php" class="menuItem" id="menuItem">
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

    <div class="content">
        <div class="filtros">
            <h3>Filtros</h3>
            <hr>
            <form action="">
                <h4>Animais</h4>
                <input type="checkbox" id="checkbox1" name="opcao1">
                <label for="checkbox1">Cachorro</label>

                <br>

                <input type="checkbox" id="checkbox2" name="opcao2">
                <label for="checkbox2">Gatos</label>

                <br>

                <input type="checkbox" id="checkbox3" name="opcao3">
                <label for="checkbox3">Animais Exóticos</label>

                <hr>

                <h4>Seção</h4>

                <input type="checkbox" id="checkbox4" name="opcao4">
                <label for="checkbox4">Rações</label>


                <br>

                <input type="checkbox" id="checkbox5" name="opcao5">
                <label for="checkbox5">Brinquedos</label>

                <br>

                <input type="checkbox" id="checkbox6" name="opcao6">
                <label for="checkbox6">Acessorios</label>
                <hr>
                <h4>Higiêne</h4>

                <input type="checkbox" id="checkbox7" name="opcao7">
                <label for="checkbox7">Shampoos</label>

                <br>

                <input type="checkbox" id="checkbox8" name="opcao8">
                <label for="checkbox8">Repelentes</label>

                <br>

                <input type="checkbox" id="checkbox9" name="opcao9">
                <label for="checkbox9">Sabonetes</label>
            </form>
        </div>
        <div class="produtos">
            <?php
            $servername = "127.0.0.1";
            $username = "root";
            $password = ''; // Substitua com sua senha
            $dbname = "sa3pwfe";

            // Cria a conexão
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Consulta para obter os dados dos produtos
            $sql = "SELECT * FROM produtos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Exibe os produtos
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="produto">';
                    echo '<img src="' . "Cadastros/" . $row['imgProduto'] . '" alt="">';
                    echo '<div>';
                    echo '<h5>' . $row['nomeProduto'] . '</h5>';
                    echo '<h4>R$' . number_format($row['preco'], 2, ',', '.') . '</h4>';
                    echo '</div>';
                    echo '<a href="compra.php?id=' . $row['id'] . '">Adicionar</a>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum produto encontrado.";
            }

            $conn->close();
            ?>

        </div>
    </div>
    <iframe src="rodape.html" frameborder="0" class="rodape"></iframe>
    <!-- <script src="js/header.js"></script> -->
    <script src="js/login.js"></script>
</body>

</html>