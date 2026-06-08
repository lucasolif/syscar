<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/mensagem.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Cadastro de Produto</h2>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConsultaProduto" title="Consultar Produtos">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <form method="post" id="formProduto">

        <div class="row">
            <div class="col-md-2 mb-2">
                <label>Código</label>
                <input type="text" name="id" id="id" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-4 mb-2">
                <label>Nome<span class="text-danger">*</span></label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="col-md-3 mb-2">
                <label>Marca<span class="text-danger">*</span></label>
                <input type="text" name="marca" id="marca" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-1">
                <label>Preço de Custo<span class="text-danger">*</span></label>
                <input type="text" name="precoCusto" id="precoCusto" class="form-control" required>
            </div>

            <div class="col-md-2 mb-1">
                <label>Preço de Venda<span class="text-danger">*</span></label>
                <input type="text" name="precoVenda" id="precoVenda" class="form-control" required>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-8 mb-3">
                <label>Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control"></textarea>
            </div>

            <div class="col-md-2 mb-3">
                <label>Status<span class="text-danger">*</span></label>
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="status" name="ativo" checked>
                    <label class="form-check-label" for="status">
                        Ativo
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" id="btnSalvar" class="btn btn-primary">
            Salvar
        </button>

        <button type="submit" id="btnAlterar" class="btn btn-warning" disabled>
            Alterar
        </button>

        <button type="submit" id="btnExcluir" class="btn btn-danger" disabled>
            Excluir
        </button>

    </form>

    <div class="modal fade" id="modalConsultaProduto" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Consultar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="campoConsultaProduto" class="form-control mb-3" placeholder="Digite o código ou nome do produto (Enter para buscar todos)">
                    <div style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody id="resultadoConsultaProduto"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/produto.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
