<?php
// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbUsuario = 'root';
$dbSenha = '';
$nomeBanco = 'sa3pwfe';

// Conexão com o banco de dados
$conexao = new mysqli($host, $dbUsuario, $dbSenha, $nomeBanco);

if($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: ".$conexao->connect_error);
}
?>