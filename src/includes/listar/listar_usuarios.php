<?php
require_once __DIR__ . '/../conexao.php';

try {
    $consulta = $conexao->query("SELECT id_usuario, nome, email, senha, aprovado FROM usuario;");

    if ($consulta) {
        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$linha['id_usuario']}</td>
                    <td>{$linha['nome']}</td>
                    <td>{$linha['email']}</td>
                    <td>{$linha['senha']}</td>";

            if ($linha['aprovado']) {
                echo "<td class='text-success fw-bold'>Aprovado</td>
                        <td>
                            <form action='../includes/deletar/usuario_deletar.php' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir?\")'>
                            <input type='hidden' name='id' value='{$linha['id_usuario']}'>
                            <button type='submit' class='btn btn-danger'>Excluir</button>
                            </form>
                        </td>";
            } else {
                echo "<td>
                        <form action='../includes/insert/inserindo-usuarios.php' method='POST'>
                            <input type='hidden' name='id' value='{$linha['id_usuario']}'>
                            <button type='submit' class='btn btn-success'>Aceitar</button>
                        </form>
                      </td>
                      <td>
                        <form action='../includes/deletar/usuario_deletar.php' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir?\")'>
                            <input type='hidden' name='id' value='{$linha['id_usuario']}'>
                            <button type='submit' class='btn btn-danger'>Excluir</button>
                        </form>
                      </td>";
            }
            echo "</tr>";
        }
    }
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}
?>
