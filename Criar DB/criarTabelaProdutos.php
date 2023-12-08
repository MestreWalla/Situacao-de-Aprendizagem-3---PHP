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

// Cria a tabela produtos
$sql_produtos = "CREATE TABLE produtos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    img VARCHAR(255),
    nome VARCHAR(50) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10,2) NOT NULL,
    tag1 VARCHAR(30),
    tag2 VARCHAR(30),
    tag3 VARCHAR(30)
)";

if ($conn->query($sql_produtos) === TRUE) {
    echo "Tabela produtos criada com sucesso";
} else {
    echo "Erro ao criar tabela produtos: " . $conn->error;
}

// Fecha a conexão
$conn->close();
?>
