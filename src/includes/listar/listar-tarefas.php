<?php
require_once __DIR__ . '/../autenticacao/autenticacao.php';

try {
    $consulta = $conexao->prepare("
        SELECT id, descricao, concluida 
        FROM Tarefa
        WHERE id_usuario = :id_usuario
        ORDER BY id DESC
    ");
    $consulta->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
            echo "<span>{$linha['descricao']}</span>";

            if (!$linha['concluida']) {
                echo "<form method='POST' action='../includes/deletar/tarefa_deletar.php' style='display: inline;'>
                        <input type='hidden' name='id_tarefa' value='{$linha['id']}'>
                        <button class='btn btn-success btn-sm' type='submit'>✔ Concluir</button>
                      </form>";
            } else {
                echo "<span class='badge bg-success'>Concluída</span>";
            }

            echo "</li>";
        }
    } else {
        echo "<li class='list-group-item text-center'>Nenhuma tarefa pendente.</li>";
    }
} catch (PDOException $erro) {
    echo "Erro ao buscar tarefas: " . $erro->getMessage();
}
?>