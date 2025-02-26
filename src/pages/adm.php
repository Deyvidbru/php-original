<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página ADM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/adm.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center flex-column">
        <div class="logo pt-5 container-box">
            <h1 class="text-center">Permissão e Negação de Usuários</h1>
        </div>

        <div class="list mt-4 container-box">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Senha</th>
                            <th scope="col">Permissão</th>
                            <th scope="col">Negação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php require_once '../includes/listar/listar_usuarios.php'; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="buscar_tarefas.php" class="btn btn-light">Buscar Tarefas por Pomodoro</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
