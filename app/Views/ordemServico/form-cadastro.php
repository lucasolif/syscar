<?php require __DIR__ . '/../layout/header.php'; ?>
<?php require __DIR__ . '/../layout/mensagem.php'; ?>

    <link rel="stylesheet" href="/assets/css/ordemServico.css">
    <div id="mensagem"></div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Ordem de Serviço</h2>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalConsultaOrdemServico">
            <i class="bi bi-search"></i>
        </button>
    </div>

    <form method="post" id="formOrdemServico">

        <div class="row">
            <div class="col-md-1 mb-2">
                <label>N° OS</label>
                <input type="text" id="id" name="id" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-2 mb-2">
                <label>Status</label>
                <input type="text" id="status" name="status" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-2 mb-2">
                <label>Dt Abertura</label>
                <input type="date" id="dataAbertura" name="dataAbertura" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-2 mb-1">
                <label>Valor Total</label>
                <input type="text" id="valorTotal" name="valorTotal" class="form-control campo-readonly" value="0.00" readonly>
            </div>

            <div class="col-md-2 mb-2">
                <label>Dt Fechamento</label>
                <input type="date" id="dataFechamento" name="dataFechamento" class="form-control campo-readonly" readonly>
            </div>

            <div class="col-md-2 mb-2">
                <label>Dt Cancelamento</label>
                <input type="date" id="dataCancelamento" name="dataCancelamento" class="form-control campo-readonly" readonly>
            </div>
        </div>

        <ul class="nav nav-tabs mt-3" id="abasOrdemServico">
            <li class="nav-item">
                <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#abaPessoaVeiculo">
                    Pessoa e Veículo
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#abaProdutos">
                    Produtos
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#abaServicos">
                    Serviços
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#abaFechamentoFaturamento">
                    Faturamento
                </button>
            </li>
        </ul>

        <div class="tab-content border border-top-0 p-3">

            <div class="tab-pane fade show active" id="abaPessoaVeiculo">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Dados da Pessoa</h5>
                    <button type="button" id="btnAddPessoa" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalConsultaPessoa">
                        Consultar Pessoa
                    </button>
                </div>


                <div class="row">
                    <div class="col-md-1 mb-1">
                        <label>Codigo</label>
                        <input type="text" id="pessoaId" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-4 mb-2">
                        <label>Nome</label>
                        <input type="text" id="pessoaNome" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>CPF</label>
                        <input type="text" id="pessoaCpf" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Telefone</label>
                        <input type="text" id="pessoaTelefone" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label>E-mail</label>
                        <input type="text" id="pessoaEmail" class="form-control campo-readonly" readonly>
                    </div>
                </div>

                <h6>Endereço</h6>

                <div class="row">

                    <div class="col-md-3 mb-2">
                        <label>Logradouro</label>
                        <input type="text" id="pessoaLogradouro" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-1 mb-2">
                        <label>Número</label>
                        <input type="text" id="pessoaNumero" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label>Complemento</label>
                        <input type="text" id="pessoaComplemento" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Bairro</label>
                        <input type="text" id="pessoaBairro" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Cidade</label>
                        <input type="text" id="pessoaCidade" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-1 mb-2">
                        <label>UF</label>
                        <input type="text" id="pessoaEstado" class="form-control campo-readonly" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Dados do Veículo</h5>
                    <button type="button" id="btnAddVeiculo" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalConsultaVeiculo">
                        Consultar Veículo
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-1 mb-1">
                        <label>Veiculo</label>
                        <input type="text" id="veiculoId" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Placa</label>
                        <input type="text" id="veiculoPlaca" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-1">
                        <label>Marca</label>
                        <input type="text" id="veiculoMarca" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-1">
                        <label>Modelo</label>
                        <input type="text" id="veiculoModelo" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-1 mb-2">
                        <label>Ano</label>
                        <input type="text" id="veiculoAno" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>Cor</label>
                        <input type="text" id="veiculoCor" class="form-control campo-readonly" readonly>
                    </div>

                    <div class="mt-3">
                        <label>Descrição do Problema/Observações</label>
                        <textarea id="descricao" name="descricao" class="form-control"></textarea>
                    </div>

                </div>
            </div>

            <div class="tab-pane fade" id="abaProdutos">
                <button type="button" id="btnAddProduto" class="btn btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalConsultaProduto">
                    Adicionar Produto
                </button>
                <div style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-hover">
                        <thead class="table-light sticky-top">
                        <tr>
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Valor Total</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody id="tabelaProdutos"></tbody>
                    </table>
                </div>

                <div class="text-end fw-bold mt-2">
                    Total Produtos: R$ <span id="totalProdutos">0,00</span>
                </div>
            </div>

            <div class="tab-pane fade" id="abaServicos">
                <button type="button" id="btnAddServico" class="btn btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalConsultaServico">
                    Adicionar Serviço
                </button>
                <div style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-hover">
                        <thead class="table-light sticky-top">
                        <tr>
                            <th>Código</th>
                            <th>Serviço</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Valor Total</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody id="tabelaServicos"></tbody>
                    </table>
                </div>
                <div class="text-end fw-bold mt-2">
                    Total Serviços: R$ <span id="totalServicos">0,00</span>
                </div>
            </div>

            <div class="tab-pane fade" id="abaFechamentoFaturamento">

                <h5>Faturamento da OS</h5>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label>Total Produtos</label>
                        <input type="text" id="totalProdutosFechamento" class="form-control campo-readonly" value="0.00" readonly>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label>Total Serviços</label>
                        <input type="text" id="totalServicosFechamento" class="form-control campo-readonly" value="0.00" readonly>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label>Valor Total OS</label>
                        <input type="text" id="valorTotalFechamento" class="form-control campo-readonly" value="0.00" readonly>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3 mb-2">
                        <label>Forma de Pagamento</label>
                        <select id="formaPagamentoId" class="form-select">
                            <option value="">Selecione</option>
                        </select>
                    </div>

                    <div class="col-md-1 mb-1">
                        <label>Parcelas</label>
                        <input type="number" id="quantidadeParcelas" class="form-control" min="1" value="1">
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>1° Vencimento</label>
                        <input type="date" id="primeiroVencimento" name="primeiroVencimento" class="form-control">
                    </div>

                    <div class="col-md-2 mb-2">
                        <label>A cada (dias)</label>
                        <input type="number" id="intervaloParcela" name="intervaloParcela" class="form-control" value="30">
                    </div>

                    <div class="col-md-2 mb-2">
                        <label class="d-block">&nbsp;</label>
                        <button type="button" id="btnFaturar" class="btn btn-dark">Faturar OS</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="mt-3">
            <button type="button" id="btnSalvar" class="btn btn-success">Salvar OS</button>
            <button type="button" id="btnFechar" class="btn btn-primary" disabled>Fechar OS</button>
            <button type="button" id="btnReabrir" class="btn btn-warning" style="display:none">Reabrir OS</button>
            <button type="button" id="btnCancelar" class="btn btn-danger" disabled>Cancelar OS</button>
        </div>
    </form>


    <div class="modal fade" id="modalConsultaPessoa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Consultar Pessoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" id="campoConsultaPessoa" class="form-control mb-3" placeholder="Digite código ou nome (Enter para buscar todos)">

                    <div style="max-height:250px; overflow-y:auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>CPF</th>
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

    <div class="modal fade" id="modalConsultaVeiculo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Consultar Veículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" id="campoConsultaVeiculo" class="form-control mb-3" placeholder="Digite código ou placa (Enter para buscar todos)">

                    <div style="max-height:250px; overflow-y:auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody id="resultadoConsultaVeiculo"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConsultaProduto" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Consultar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" id="campoConsultaProduto" class="form-control mb-3" placeholder="Digite código ou nome (Enter para buscar todos)">

                    <div style="max-height:250px; overflow-y:auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Produto</th>
                                <th>Marca</th>
                                <th>Valor</th>
                                <th>Qtd</th>
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

    <div class="modal fade" id="modalConsultaServico" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Consultar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" id="campoConsultaServico" class="form-control mb-3" placeholder="Digite código ou nome (Enter para buscar todos)">

                    <div style="max-height:250px; overflow-y:auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Serviço</th>
                                <th>Valor</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody id="resultadoConsultaServico"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConsultaOrdemServico" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Consultar Ordem Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" id="campoConsultaOrdemServico" class="form-control mb-3" placeholder="Digite n° OS, placa do veículo, código ou nome da pessoa">

                    <div style="max-height:250px; overflow-y:auto;">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>N° OS</th>
                                <th>Cliente</th>
                                <th>Veículo</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody id="resultadoConsultaOrdemServico"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/ordemServico/cadastro.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>