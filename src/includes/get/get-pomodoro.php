<?php
include_once '../includes/autenticacao/autenticacao.php';

$id_usuario = $_SESSION['id_usuario'];

try {
    $consulta = $conexao->prepare("
        SELECT duracao, duracao_pausa, duracao_pausalonga, ciclos 
        FROM Pomodoro 
        WHERE id_usuario = :id_usuario
    ");
    $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $consulta->execute();
    $pomodoroConfig = $consulta->fetch(PDO::FETCH_ASSOC);
    if (!$pomodoroConfig) {
        $stmt = $conexao->prepare("
            INSERT INTO Pomodoro (duracao, duracao_pausa, duracao_pausalonga, ciclos, id_usuario) 
            VALUES (25, 5, 15, 0, :id_usuario)
        ");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $pomodoroConfig = [
            'duracao' => 25,
            'duracao_pausa' => 5,
            'duracao_pausalonga' => 15,
            'ciclos' => 0
        ];
    }
} catch (PDOException $erro) {
    die("Erro ao buscar configuração do Pomodoro: " . $erro->getMessage());
}
?>
