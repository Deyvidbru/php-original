<?php
include_once '../autenticacao/autenticacao.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; 
    $id_usuario = $_SESSION['id_usuario']; 

    try {
        $comando = $conexao->prepare("DELETE FROM Tarefa WHERE id = :id AND id_usuario = :id_usuario");
        $comando->bindParam(':id', $id);
        $comando->bindParam(':id_usuario', $id_usuario);
        $comando->execute();

        echo "<script>alert('Tarefa concluída com sucesso!'); window.location.href='../../pages/pomodoro.php';</script>";
    } catch (PDOException $erro) {
        echo "Erro ao excluir tarefa: " . $erro->getMessage();
    }
}
?>
