<?php
include_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (isset($_POST['id'])) {
            $id_usuario = $_POST['id'];

            $comando = $conexao->prepare("UPDATE usuario SET aprovado = TRUE WHERE id_usuario = :id_usuario");
            $comando->bindParam(':id_usuario', $id_usuario);

            if ($comando->execute()) {
                header("Location: ../../pages/adm.php");
                exit();
            } else {
                echo "Erro ao aprovar o usuário.";
            }
        } else {
            $email = $_POST['email'];
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            if ($senha !== $confirmar_senha) {
                echo "<script>alert('As senhas não coincidem!'); window.location.href='../../pages/users/cadastro.html';</script>";
                exit();
            }

            $comando = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
            $comando->bindParam(':email', $email);
            $comando->execute();
            $emailExiste = $comando->fetchColumn();

            if ($email === 'adm@gmail.com' || $emailExiste > 0) {
                echo "<script>alert('E-mail já utilizado!'); window.location.href='../../pages/users/cadastro.php';</script>";
                exit();
            }

            $comando = $conexao->prepare("INSERT INTO usuario (email, nome, senha, aprovado) VALUES (:email, :nome, :senha, FALSE)");
            $comando->bindParam(':email', $email);
            $comando->bindParam(':nome', $nome);
            $comando->bindParam(':senha', $senha);

            if ($comando->execute()) {
                header("Location: ../../pages/users/login.php"); 
                exit();
            }
        }
    } catch (PDOException $erro) {
        echo "Erro ao processar requisição: " . $erro->getMessage();
    }
}
?>
