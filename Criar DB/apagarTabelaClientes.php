<?php
$servername = "127.0.0.1";
$username = "root";
$password = '';
$dbname = "sa3pwfe";

// Conectar ao MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Código para apagar a tabela clientes
$sql_drop_table_clientes = "DROP TABLE IF EXISTS clientes";

if ($conn->query($sql_drop_table_clientes) === TRUE) {
    echo "Tabela clientes apagada com sucesso";
} else {
    echo "Erro ao apagar tabela clientes: " . $conn->error;
}

// Fechar a conexão
$conn->close();
?>
