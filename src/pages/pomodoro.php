<?php
include_once  '../includes/autenticacao/autenticacao.php';

$id_usuario = $_SESSION['id_usuario'];

try {
    $consulta = $conexao->prepare("
        SELECT id, descricao, concluida FROM Tarefa 
        WHERE id_usuario = :id_usuario 
        ORDER BY id DESC
    ");
    $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $consulta->execute();
    $tarefas = $consulta->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    die("Erro ao buscar tarefas: " . $erro->getMessage());
}
?>
<?php include_once '../includes/get/get-pomodoro.php'; ?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pomodoro Harmony</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/pomodoro.css">
</head>
<body>
    <div class="card">
        <h2>Pomodoro Harmony</h2>
        <p>Bem-vindo, <strong><?= $_SESSION['nome_usuario'];?></strong>!</p>

        <div class="btn-group d-flex flex-wrap">
            <button class="btn btn-outline-secondary" onclick="startPomodoroCycle()">INICIAR</button>
            <button class="btn btn-outline-secondary" onclick="startBreakTimer()">Pausa</button>
            <button class="btn btn-outline-secondary" onclick="startLongBreakTimer()">Pausa Longa</button>
        </div>
        
        <div id="timer">25:00</div>
        
        <div class="btn-container">
            <button class="btn btn-outline-secondary" onclick="resetTimer()">REINICIAR</button>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#meuModal">Lista de tarefas</button>
        </div>
    </div>
    <div class="modal fade" id="meuModal" tabindex="-1" aria-labelledby="meuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meuModalLabel">Lista de Tarefas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Total de Tarefas: <strong><?= count($tarefas); ?></strong></p>
                    <form action="../includes/insert/inserindo-tarefa.php" method="POST" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="descricao" placeholder="Digite sua tarefa" required>
                            <button class="btn btn-primary" type="submit">Adicionar</button>
                        </div>
                    </form>
                    <ul id="listaTarefas" class="list-group">
                        <?php if (!empty($tarefas)): ?>
                            <?php foreach ($tarefas as $tarefa): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= htmlspecialchars($tarefa['descricao']); ?></span>
                                    <?php if (!$tarefa['concluida']): ?>
                                        <form method="POST" action="../includes/deletar/tarefa_deletar.php" style="display: inline;">
                                            <input type="hidden" name="id" value="<?= $tarefa['id']; ?>">
                                            <button class="btn btn-success btn-sm" type="submit">✔ Concluir</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="badge bg-success">Concluída</span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-center">Nenhuma tarefa pendente.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        let timer;
        let minutes = <?php echo $pomodoroConfig['duracao']; ?>;
        let seconds = 0;
        let isRunning = false;
        let cicloCount = 0;

        function updateTimerDisplay() {
            let min = minutes < 10 ? "0" + minutes : minutes;
            let sec = seconds < 10 ? "0" + seconds : seconds;
            document.getElementById("timer").innerText = min + ":" + sec;
        }

        function startPomodoroCycle() {
            cicloCount = 0;
            startStudySession();
        }

        function startStudySession() {
            if (!isRunning) {
                isRunning = true;
                minutes = <?php echo $pomodoroConfig['duracao']; ?>;
                seconds = 0;
                updateTimerDisplay();
                timer = setInterval(() => {
                    if (seconds === 0) {
                        if (minutes === 0) {
                            clearInterval(timer);
                            isRunning = false;
                            cicloCount++;
                            alert("Tempo esgotado! Ciclo " + cicloCount + " concluído.");

                            if (cicloCount < 4) {
                                startBreakTimer();
                            } else {
                                cicloCount = 0; 
                                startLongBreakTimer();
                            }
                        } else {
                            minutes--;
                            seconds = 59;
                        }
                    } else {
                        seconds--;
                    }
                    updateTimerDisplay();
                }, 1000);
            }
        }


        function startBreakTimer(callback = null) {
            if (!isRunning) {
                isRunning = true;
                minutes = <?php echo $pomodoroConfig['duracao_pausa']; ?>;
                seconds = 0;
                updateTimerDisplay();
                timer = setInterval(() => {
                    if (seconds === 0) {
                        if (minutes === 0) {
                            clearInterval(timer);
                            isRunning = false;
                            alert("Pausa finalizada!");
                            if (callback) {
                                callback();
                            } else {
                                startStudySession();
                            }
                        } else {
                            minutes--;
                            seconds = 59;
                        }
                    } else {
                        seconds--;
                    }
                    updateTimerDisplay();
                }, 1000);
            }
        }

        function startLongBreakTimer() {
            if (!isRunning) {
                isRunning = true;
                minutes = <?php echo $pomodoroConfig['duracao_pausalonga']; ?>;
                seconds = 0;
                updateTimerDisplay();
                timer = setInterval(() => {
                    if (seconds === 0) {
                        if (minutes === 0) {
                            clearInterval(timer);
                            isRunning = false;
                            cicloCount = 0;
                            alert("Pausa longa finalizada!");
                            startStudySession();
                        } else {
                            minutes--;
                            seconds = 59;
                        }
                    } else {
                        seconds--;
                    }
                    updateTimerDisplay();
                }, 1000);
            }
        }

        function resetTimer() {
            clearInterval(timer);
            isRunning = false;
            minutes = <?php echo $pomodoroConfig['duracao']; ?>;
            seconds = 0;
            cicloCount = 0;
            updateTimerDisplay();
        }
    </script>
</body>
</html>