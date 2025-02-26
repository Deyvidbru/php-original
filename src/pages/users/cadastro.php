<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/usuario.css">
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container-box">
        <header class="mb-4 text-center">
            <h2>Cadastro</h2>
        </header>

        <main>
            <form action="../../includes/insert/inserindo-usuarios.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu email" required>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome" required>
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
                </div>

                <div class="mb-3">
                    <label for="confirmar_senha" class="form-label">Confirme sua senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" placeholder="Confirme sua senha" required>
                </div>

                <div class="d-grid">
                    <input type="submit" value="Cadastrar" class="btn btn-light">
                </div>
            </form>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
