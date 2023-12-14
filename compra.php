<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/compra.css">
    <link rel="stylesheet" href="styles/root.css">
    <title>Detalhes do Produto</title>
</head>

<body>
<header class="header">
        <div class="menu01">
            <img src="img/logo.png" alt="Logo">
            <div class="buscar">
                <input type="PESQUISAR" placeholder="BUSCAR">
                <img src="img/lupa.png" alt="">
            </div>
            <a href="http://localhost/php/Maycon%20PHP/Situacao-de-Aprendizagem-3---PHP/login.php" style="text-decoration: none;"><button class="logar" id="logar">
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
        <?php
        // Verifica se há um ID de produto na URL
        if (isset($_GET['id'])) {
            $produto_id = $_GET['id'];

            // Conecta-se ao banco de dados
            $servername = "127.0.0.1";
            $username = "root";
            $password = ''; // Substitua com sua senha
            $dbname = "sa3pwfe";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Consulta para obter os detalhes do produto com base no ID
            $sql = "SELECT * FROM produtos WHERE id = $produto_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Exibe os detalhes do produto
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="produto">';
                    echo '<img src="' . "Cadastros/" . $row['imgProduto'] . '" alt="">';
                    echo '<div>';
                    echo '<h1>' . $row['nomeProduto'] . '</h1>';
                    echo '<h2>Informações</h2>';
                    echo '<h5>' . $row['descricao'] . '</h5>';
                    echo '<h4>R$' . number_format($row['preco'], 2, ',', '.') . '</h4>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum produto encontrado.";
            }

            $conn->close();
        } else {
            echo "ID do produto não especificado.";
        }
        ?>
    </div>

    <iframe src="rodape.html" frameborder="0" class="rodape"></iframe>
    <script src="js/carrinho.js"></script>
</body>

</html>

 
 
 <!-- <!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/compra.css">
  <link rel="stylesheet" href="styles/header.css">
  <link rel="stylesheet" href="styles/loginCadastro.css">
  <link rel="stylesheet" href="styles/root.css">
  <title>Carrinho de Compras</title>

</head>

<body>
  
  <iframe src="login.html" id="IframeLogar"></iframe>
  <div class="produto">
    <div class="produtoImg">
      <img src="img/racao/caes/01racao-golden-special-para-caes-adultos-frango-e-carne-3310549-15kg-Lado.webp" alt="">
    </div>
    <div>
      <h1>Ração Golden Special para Cães Adultos Frango e Carne 15 kg</h1><br>
      <h2>Informações</h2>
      <h5>- Indicada para cães adultos;<br>
        - Blend de proteínas;<br>
        - Músculos mais fortes;<br>
        - Redução do odor das fezes;<br>
        - Mais rendimento por quilo;<br>
        - Saúde e vitalidade;<br>
        - Livre de aromatizantes e corantes artificiais.</h5>
      <div class="container content">
        <h2>Carrinho de Compras</h2>
        <table class="center-table">
          <tr>
          </tr>
           <tr>
            <td>R$ 140.00</td>
            <td>
              <button class="quantity-button" data-action="decrease">-</button>
              <input class="quantity-input" type="number" inputmode="numeric" value="2">
              <button class="quantity-button" data-action="increase">+</button>
            </td>
            <td><button class="button">
                <img src="img/+-removebg-preview (1).png" class="svgIcon">
              </button></td>
          </tr>
        </table>
      </div>
    </div>


  </div>
  <iframe src="rodape.html" frameborder="0" class="rodape"></iframe>
  <script src="js/carrinho.js"></script>
</body>

</html> -->