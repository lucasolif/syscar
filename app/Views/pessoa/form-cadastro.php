<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/mensagem.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Cadastro de Pessoa</h2>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConsultaPessoa" title="Consultar Pessoas">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <form method="post" id="formPessoa">

        <div class="row">
            <div class="col-md-1 mb-1">
                <label>Código</label>
                <input type="text" name="id" id="id" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-5 mb-2">
                <label>Nome<span class="text-danger">*</span></label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="col-md-2 mb-2">
                <label>CPF<span class="text-danger">*</span></label>
                <input type="text" name="cpf" id="cpf" class="form-control" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-1">
                <label>Telefone<span class="text-danger">*</span></label>
                <input type="text" name="telefone" id="telefone" class="form-control" required>
            </div>

            <div class="col-md-3 mb-2">
                <label>E-mail<span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="col-md-2 mb-2">
                <label>Data de Nascimento</label>
                <input type="date" name="dataNascimento" id="dataNascimento" class="form-control">
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

        <h5>Endereço</h5>

        <div class="row">
            <div class="col-md-3 mb-2">
                <label>Logradouro<span class="text-danger">*</span></label>
                <input type="text" name="logradouro" id="logradouro" class="form-control" required>
            </div>

            <div class="col-md-1 mb-1">
                <label>Número<span class="text-danger">*</span></label>
                <input type="text" name="numero" id="numero" class="form-control" required>
            </div>

            <div class="col-md-3 mb-2">
                <label>Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-2">
                <label>Bairro<span class="text-danger">*</span></label>
                <input type="text" name="bairro" id="bairro" class="form-control" required>
            </div>

            <div class="col-md-3 mb-2">
                <label>Cidade<span class="text-danger">*</span></label>
                <input type="text" name="cidade" id="cidade" class="form-control" required>
            </div>

            <div class="col-md-2 mb-3">
                <label>CEP<span class="text-danger">*</span></label>
                <input type="text" name="cep" id="cep" class="form-control" required>
            </div>

            <div class="col-md-1 mb-1">
                <label>Estado<span class="text-danger">*</span></label>

                <select name="estado" id="estado" class="form-select" required>
                    <option value="">Selecione</option>

                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AP">AP</option>
                    <option value="AM">AM</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="DF">DF</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MT">MT</option>
                    <option value="MS">MS</option>
                    <option value="MG">MG</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PR">PR</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RS">RS</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="SC">SC</option>
                    <option value="SP">SP</option>
                    <option value="SE">SE</option>
                    <option value="TO">TO</option>
                </select>
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

    <div class="modal fade" id="modalConsultaPessoa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Consultar Pessoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="campoConsultaPessoa" class="form-control mb-3" placeholder="Digite o código ou nome (Enter para buscar todos)">
                    <div style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody id="resultadoConsultaPessoa"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/pessoa.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>