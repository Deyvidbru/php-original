<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Usuário não autenticado! Faça login novamente.'); window.location.href='../../pages/users/login.html';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario']; 
?>

