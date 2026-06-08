<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Syscar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/login.css">

</head>

<body>

    <div class="container d-flex justify-content-center align-items-center login-container">

        <div class="w-100" style="max-width: 420px;">

            <div class="text-center mb-4">
                <h1 class="system-name">Syscar</h1>
                <p class="system-subtitle mb-0">Sistema para Oficina Mecânica</p>
            </div>

            <div class="card login-card">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <div class="login-icon">🔐</div>
                        <h4 class="login-title mt-2">Acesso ao Sistema</h4>
                    </div>

                    <?php require __DIR__ . '/../layout/mensagem.php'; ?>

                    <form method="post" action="/login/autenticar">
                        <div class="mb-3">
                            <label>Login</label>
                            <input type="text" name="login" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label>Senha</label>
                            <input type="password" name="senha" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-login w-100 mt-2">
                            Entrar
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>