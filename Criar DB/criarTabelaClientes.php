<?php
$servername = "127.0.0.1";
$username = "root";
$password = '';
$dbname = "sa3pwfe";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a tabela já existe
$tableExists = $conn->query("SHOW TABLES LIKE 'clientes'");

if ($tableExists->num_rows == 0) {
    // Cria a tabela clientes
    $sql_clientes = "CREATE TABLE clientes (
        -- id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        img VARCHAR(255),
        adm BOOLEAN,
        nome VARCHAR(30) NOT NULL,
        sobrenome VARCHAR(30) NOT NULL,
        nascimento DATE,
        cpf VARCHAR(14) NOT NULL,
        rua VARCHAR(255),
        n VARCHAR(10),
        complemento VARCHAR(50),
        cidade VARCHAR(50),
        uf VARCHAR(2),
        cep VARCHAR(10),
        email VARCHAR(50) UNIQUE PRIMARY KEY,
        senha VARCHAR(255) NOT NULL,
        usuario VARCHAR(30) NOT NULL
    )";

    if ($conn->query($sql_clientes) === TRUE) {
        echo "Tabela clientes criada com sucesso";
    } else {
        echo "Erro ao criar tabela clientes: " . $conn->error;
    }
} else {
    echo "A tabela clientes já existe.";
}

// Fecha a conexão
$conn->close();
?>
