<?php
session_start();
include_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $comando = $conexao->prepare("SELECT email, senha FROM administrador WHERE email = :email AND senha = :senha");
        $comando->bindParam(':email', $email);
        $comando->bindParam(':senha', $senha);
        $comando->execute();

        if ($comando->rowCount() > 0) {
            header("Location: ../../pages/adm.php");
            exit();
        }

        $comando = $conexao->prepare("
            SELECT id_usuario, nome 
            FROM usuario 
            WHERE email = :email AND senha = :senha AND aprovado = TRUE
        ");

        $comando->bindParam(':email', $email);
        $comando->bindParam(':senha', $senha);
        $comando->execute();

        if ($comando->rowCount() > 0) {
            $usuario = $comando->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome'];


            header("Location: ../../pages/pomodoro.php"); 
            exit();
        } else {
            echo "<script>alert('Login inválido ou usuário não aprovado!'); window.location.href='../../pages/users/login.php';</script>";
        }
    } catch (PDOException $erro) {
        echo "Erro ao verificar login: " . $erro->getMessage();
    }
}

?>

