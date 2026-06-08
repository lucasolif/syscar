<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/mensagem.php'; ?>

    <div class="d-flex align-items-center mb-3">
        <h2 class="mb-0 me-3">Movimentação de Estoque</h2>
    </div>

    <form method="post" id="formMovimentacaoEstoque">

        <div class="row">
            <div class="col-md-1 mb-1">
                <label>Código<span class="text-danger">*</span></label>
                <input type="text" name="produtoId" id="produtoId" class="form-control campo-readonly" readonly required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Produto<span class="text-danger">*</span></label>
                <input type="text" name="produtoNome" id="produtoNome" class="form-control campo-readonly" readonly required>
            </div>
            <div class="col-md-1 mb-1">
                <label class="d-block">&nbsp;</label>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConsultaProduto" title="Consultar Produto">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1 mb-1">
                <label>Quantidade<span class="text-danger">*</span></label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" required>
            </div>

            <div class="col-md-2 mb-2">
                <label>Tipo de Movimentação<span class="text-danger">*</span></label>
                <select name="tipoMovimento" id="tipoMovimento" class="form-select" required>
                    <option value="">Selecione</option>
                    <option value="ENTRADA">Entrada</option>
                    <option value="SAIDA">Saída</option>
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" id="btnSalvar" class="btn btn-success">
                    Salvar
                </button>
            </div>
        </div>
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
                                <th>Marca</th>
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

    <script src="/assets/js/estoque.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>