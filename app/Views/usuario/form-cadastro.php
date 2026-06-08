<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/mensagem.php'; ?>

    <div id="mensagem"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Cadastro de Usuário</h2>

        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConsultaUsuario" title="Consultar Usuários">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <form method="post" id="formUsuario">

        <div class="row">
            <div class="col-md-1 mb-2">
                <label>Código</label>
                <input type="text" name="id" id="id" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-3 mb-2">
                <label>Nome<span class="text-danger">*</span></label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="col-md-2 mb-3">
                <label>Status<span class="text-danger">*</span></label>

                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo" checked>
                    <label class="form-check-label" for="ativo">
                        Ativo
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-4">
                <label>Login<span class="text-danger">*</span></label>
                <input type="text" name="login" id="login" class="form-control" required>
            </div>

            <div class="col-md-2 mb-4">
                <label>Senha<span class="text-danger">*</span></label>
                <input type="password" name="senha" id="senha" class="form-control">
            </div>

            <div class="col-md-2 mb-4">
                <label>Senha<span class="text-danger">*</span></label>
                <input type="password" name="confirmacaoSenha" id="confirmacaoSenha" class="form-control">
            </div>
        </div>

        <button type="submit" id="btnSalvar" class="btn btn-success">Salvar</button>
        <button type="submit" id="btnAlterar" class="btn btn-warning" disabled>Alterar</button>
        <button type="submit" id="btnExcluir" class="btn btn-danger" disabled>Excluir</button>
    </form>

    <div class="modal fade" id="modalConsultaUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Consultar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="campoConsultaUsuario" class="form-control mb-3" placeholder="Digite o código ou login (Enter para buscar todos)">

                    <div style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nome</th>
                                    <th>Login</th>
                                    <th>Status</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>

                            <tbody id="resultadoConsultaUsuario"></tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script src="/assets/js/usuario.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>