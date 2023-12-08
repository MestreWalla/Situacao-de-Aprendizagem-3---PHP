<?php
$servername = "127.0.0.1";
$username = "root";
$password = '';

// Conectar ao MySQL
$conn = new mysqli($servername, $username, $password);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Nome do banco de dados a ser apagado
$dbname = "sa3pwfe";

// Código para apagar o banco de dados
$sql_drop_db = "DROP DATABASE IF EXISTS $dbname";

if ($conn->query($sql_drop_db) === TRUE) {
    echo "Banco de dados apagado com sucesso";
} else {
    echo "Erro ao apagar banco de dados: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
