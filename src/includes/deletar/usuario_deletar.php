<?php
include_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_usuario = intval($_POST['id']); 

    try {
        $comando = $conexao->prepare("DELETE FROM usuario WHERE id_usuario = :id");
        $comando->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        if ($comando->execute()) {
            echo "<script>alert('Usuário excluído com sucesso!'); window.location.href='../../pages/adm.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir usuário.'); window.location.href='../../pages/adm.php';</script>";
        }
    } catch (PDOException $erro) {
        echo "<script>alert('Erro ao excluir usuário: " . $erro->getMessage() . "'); window.location.href='../../pages/adm.php';</script>";
    }
} else {
    echo "<script>alert('ID inválido!'); window.location.href='../../pages/adm.php';</script>";
}
?>
