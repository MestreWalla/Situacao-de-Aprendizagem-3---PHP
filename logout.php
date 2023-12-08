<?php
session_start();

// Verificar se a sessão está iniciada antes de tentar destruí-la
if (session_status() == PHP_SESSION_ACTIVE) {
    // Destruir a sessão
    session_destroy();
}

// Redirecionar para a página de login
header('location: login.php');
exit();
?>
