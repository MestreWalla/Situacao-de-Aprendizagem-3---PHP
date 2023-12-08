<?php
session_start();
include('conectar.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Verificar se o usuário está autenticado
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['adm'], $_POST['email'], $_POST['nome'], $_POST['sobrenome'], $_POST['nascimento'], $_POST['cpf'], $_POST['rua'], $_POST['n'], $_POST['cep'], $_POST['cidade'], $_POST['uf'], $_POST['complemento'])) {
    // Processar dados do formulário de edição
    $adm = isset($_POST['adm']) ? filter_var($_POST['adm'], FILTER_VALIDATE_BOOLEAN) : false;
    $emailCliente = $_POST['email'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nascimento = $_POST['nascimento'];
    $cpf = $_POST['cpf'];
    $rua = $_POST['rua'];
    $n = $_POST['n'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $complemento = $_POST['complemento'];

    // Executar a atualização usando declaração preparada
    $queryUpdate = "UPDATE clientes SET adm=?, nome=?, sobrenome=?, nascimento=?, cpf=?, rua=?, n=?, cep=?, cidade=?, uf=?, complemento=? WHERE email=?";
    $stmtUpdate = $conexao->prepare($queryUpdate);

    if ($stmtUpdate) {
        // Correção no tipo de dado para $adm
        $stmtUpdate->bind_param('isssssssssss', $adm, $nome, $sobrenome, $nascimento, $cpf, $rua, $n, $cep, $cidade, $uf, $complemento, $emailCliente);
        $stmtUpdate->execute();

        if ($stmtUpdate->affected_rows > 0) {
            $stmtUpdate->close();
            header('Location: dashboardClientes.php?edit_success=true');
            exit();
        } else {
            // Exibir mensagem de erro específica
            echo "Erro ao atualizar o usuário. Erro: " . $stmtUpdate->error;
        }
    } else {
        // Exibir mensagem de erro específica
        echo "Erro na preparação da consulta de atualização. Erro: " . $conexao->error;
    }
} else {
    echo "Parâmetros do formulário ausentes.";
}
?>