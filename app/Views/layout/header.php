<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Oficina</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/header.js" defer></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">Syscar</a>


        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuMobile" aria-controls="menuMobile">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuProdutoServico" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Produto e Serviços
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="menuProdutoServico">

                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">
                                Produto
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/produto">
                                        Cadastrar/Alterar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/produto/consultar">
                                        Consultar Produto
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">
                                Serviço
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/servico">
                                        Cadastrar/Alterar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuPessoas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Pessoas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuPessoas">
                        <li>
                            <a class="dropdown-item" href="/pessoa">
                                Cadastrar/Alterar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/pessoa/consultar">
                                Consultar Pessoas
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuEntidades" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Entidades
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuEntidades">
                        <li>
                            <a class="dropdown-item" href="/conta-caixa">
                                Conta Caixa
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/forma-pagamento">
                                Forma de Pagamento
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/usuario">
                                Usuario
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuVeiculo" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Veículos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuVeiculo">
                        <li>
                            <a class="dropdown-item" href="/veiculo">
                                Cadastrar/Alterar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/veiculo/consultar">
                                Consultar Veículos
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuEstoque" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Estoque
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuEstoque">
                        <li>
                            <a class="dropdown-item" href="/estoque">
                                Entrada/Saída Produtos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/estoque/consultar">
                                Consultar Estoque
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/estoque/consultar-movimentacao">
                                Consultar Movimentações
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuOrdemServico" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ordem de Serviço
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuOrdemServico">
                        <li>
                            <a class="dropdown-item" href="/ordem-servico">
                                Ordem Serviço
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/ordem-servico/consultar">
                                Consultar OS
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuFinanceiro" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Financeiro
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="menuFinanceiro">

                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">
                                Contas a Receber
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/produto">
                                        Cadastrar/Alterar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/conta-receber/consultar">
                                        Consultar
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">
                                Caixa
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="/servico">
                                        Cadastrar/Alterar
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="nav-item dropdown ms-2">
                <a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center" href="#" id="menuUsuario" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="usuario-icone">
                        <i class="bi bi-person-fill"></i>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuUsuario">
                    <li class="dropdown-header">
                        <?= $_SESSION['usuario_login'] ?? 'Usuário' ?>
                    </li>

                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalAlterarSenha">
                            Alterar senha
                        </button>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="/logout">
                            Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="modalAlterarSenha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="/usuario/alterar-senha" id="formAlterarSenha">

                <div class="modal-header">
                    <h5 class="modal-title">Alterar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <?php require __DIR__ . '/../layout/mensagem.php'; ?>
                    <input type="hidden" name="id" id="usuarioSenhaId" value="<?= $_SESSION['usuario_id'] ?? '' ?>">

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Login</label>
                            <input type="text" name="login" id="usuarioSenhaLogin" class="form-control campo-readonly" value="<?= $_SESSION['usuario_login'] ?? '' ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Senha Atual</label>
                            <input type="password" name="senhaAtual" id="senhaAtual" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Nova Senha</label>
                            <input type="password" name="senha" id="novaSenha" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Confirmar Senha</label>
                            <input type="password" name="confirmacaoSenha" id="confirmacaoSenha" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Fechar
                    </button>

                    <button type="submit" class="btn btn-success">
                        Confirmar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php if (!empty($_SESSION['abrirModal'])): ?>
    <script>
        window.abrirModalAlterarSenha = true;
    </script>
    <?php unset($_SESSION['abrirModal']); ?>
<?php endif; ?>

<div class="container">

