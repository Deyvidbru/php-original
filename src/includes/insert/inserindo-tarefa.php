<?php
include_once '../autenticacao/autenticacao.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['descricao']) || empty(trim($_POST['descricao']))) {
        echo "<script>alert('A descrição da tarefa não pode estar vazia!'); window.location.href='../../pages/pomodoro.php';</script>";
        exit();
    }

    $descricao = trim($_POST['descricao']);

    try {
        $comando = $conexao->prepare("
            INSERT INTO Tarefa (descricao, id_usuario, concluida) 
            VALUES (:descricao, :id_usuario, FALSE)
        ");
        $comando->bindParam(':descricao', $descricao);
        $comando->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $comando->execute();

        echo "<script>alert('Tarefa adicionada com sucesso!'); window.location.href='../../pages/pomodoro.php';</script>";
    } catch (PDOException $erro) {
        echo "Erro ao processar requisição: " . $erro->getMessage();
    }
}
?>
