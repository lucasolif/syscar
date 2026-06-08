<?php require __DIR__ . '/layout/header.php'; ?>

    <link rel="stylesheet" href="/assets/css/home.css">
    <div class="p-5 mb-4 bg-light rounded-3">
        <h1 class="display-5 fw-bold">Syscar - Gestor de Oficina</h1>

        <p class="fs-5">
            Sistema de Gestão para Oficinas com controle de produtos, estoque, pessoas, veículos, serviços, caixa e ordens de serviço.
        </p>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Produtos</h5>
                    <p>Cadastro e consulta.</p>
                    <a href="/produto" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Pessoas</h5>
                    <p>Clientes e contatos.</p>
                    <a href="/pessoa" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Veículos</h5>
                    <p>Veículos dos clientes.</p>
                    <a href="/veiculo" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>OS</h5>
                    <p>Ordens de serviço.</p>
                    <a href="/ordem-servico" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Estoque</h5>
                    <p>Movimentação e consulta.</p>
                    <a href="/estoque" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Serviços</h5>
                    <p>Cadastro e consulta.</p>
                    <a href="/servico" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Contas a Receber</h5>
                    <p>Liquidação e consultas.</p>
                    <a href="/conta-receber" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Caixa</h5>
                    <p>Movimentações e consulta.</p>
                    <a href="/caixa" class="btn btn-sm btn-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>


<?php require __DIR__ . '/layout/footer.php'; ?>