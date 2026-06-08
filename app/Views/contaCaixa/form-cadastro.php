<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/mensagem.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Cadastro de Conta Caixa</h2>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConsultaContaCaixa" title="Consultar Conta Caixa">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <form method="post" id="formContaCaixa">
        <div class="row">
            <div class="col-md-1 mb-3">
                <label>Código</label>
                <input type="text" name="id" id="id" class="form-control campo-readonly" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label>Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 mb-3">
                <label>Agência</label>
                <input type="text" name="agencia" id="agencia" class="form-control" maxlength="10" required>
            </div>

            <div class="col-md-2 mb-3">
                <label>Conta</label>
                <input type="text" name="conta" id="conta" class="form-control" maxlength="15">
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

    <div class="modal fade" id="modalConsultaContaCaixa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Consultar Conta Caixa
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="campoConsultaContaCaixa" class="form-control mb-3" placeholder="Digite o código ou nome da conta (Enter para buscar todos)">
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

                            <tbody id="resultadoConsultaContaCaixa"></tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="/assets/js/contaCaixa.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>