<?php
session_start();
include_once '../includes/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Tarefas por Pomodoro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Buscar Tarefas pelo ID do Pomodoro</h2>
        <form method="POST" action="buscar_tarefas.php" class="mt-4">
            <div class="mb-3">
                <label for="id_pomodoro" class="form-label">ID do Pomodoro:</label>
                <input type="number" class="form-control" id="id_pomodoro" name="id_pomodoro" required>
            </div>
            <button type="submit" class="btn btn-light">Buscar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pomodoro'])) {
            $id_pomodoro = $_POST['id_pomodoro'];

            try {
                $consulta = $conexao->prepare("
                    SELECT t.id, t.descricao, t.concluida, u.nome AS usuario_nome 
                    FROM Tarefa t
                    INNER JOIN Usuario u ON t.id_usuario = u.id_usuario
                    INNER JOIN Pomodoro p ON p.id_usuario = u.id_usuario
                    WHERE p.id = :id_pomodoro
                ");
                $consulta->bindParam(':id_pomodoro', $id_pomodoro, PDO::PARAM_INT);
                $consulta->execute();

                if ($consulta->rowCount() > 0) {
                    echo "<h3 class='mt-4'>Tarefas Encontradas:</h3>";
                    echo "<ul class='list-group mt-3'>";
                    while ($tarefa = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        $status = $tarefa['concluida'] ? 'Concluída' : 'Pendente';
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                        echo "<span>{$tarefa['descricao']} - <strong>{$tarefa['usuario_nome']}</strong></span>";
                        echo "<span>{$status}</span>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='mt-4 text-danger'>Nenhuma tarefa encontrada para esse ID de Pomodoro.</p>";
                }
            } catch (PDOException $erro) {
                echo "<p class='text-danger'>Erro ao buscar tarefas: " . $erro->getMessage() . "</p>";
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
