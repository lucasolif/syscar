<?php require __DIR__ . '/../layout/header.php'; ?>

    <link rel="stylesheet" href="/assets/css/ordemServico.css">
    <div id="mensagem"></div>
    <h2>Consulta de Ordens de Serviço</h2>

    <form method="get" action="/ordem-servico/consultar" class="mb-4">

        <div class="row">
            <div class="col-md-1 mb-2">
                <label>N° OS</label>
                <input type="text" name="id" class="form-control" value="<?= $_GET['id'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Cliente</label>
                <input type="text" name="pessoa" class="form-control" value="<?= $_GET['pessoa'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Placa</label>
                <input type="text" name="placa" class="form-control" value="<?= $_GET['placa'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="ABERTA" <?= ($_GET['status'] ?? '') === 'ABERTA' ? 'selected' : '' ?>>Aberta</option>
                    <option value="FECHADA" <?= ($_GET['status'] ?? '') === 'FECHADA' ? 'selected' : '' ?>>Fechada</option>
                    <option value="FATURADA" <?= ($_GET['status'] ?? '') === 'FATURADA' ? 'selected' : '' ?>>Faturada</option>
                    <option value="CANCELADA" <?= ($_GET['status'] ?? '') === 'CANCELADA' ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <label>Abertura Inicial</label>
                <input type="date" name="dataAberturaInicial" class="form-control" value="<?= $_GET['dataAberturaInicial'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Abertura Final</label>
                <input type="date" name="dataAberturaFinal" class="form-control" value="<?= $_GET['dataAberturaFinal'] ?? '' ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-2">
                <label>Fechamento Inical</label>
                <input type="date" name="dataFechamentoInicial" class="form-control" value="<?= $_GET['dataFechamentoInicial'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Fechamento Final</label>
                <input type="date" name="dataFechamentoFinal" class="form-control" value="<?= $_GET['dataFechamentoFinal'] ?? '' ?>">
            </div>
            <div class="col-md-2 mb-2">
                <label>Faturamento Inicial</label>
                <input type="date" name="dataFaturamentoInicial" class="form-control" value="<?= $_GET['dataFaturamentoInicial'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Faturamento Final</label>
                <input type="date" name="dataFaturamentoFinal" class="form-control" value="<?= $_GET['dataFaturamentoFinal'] ?? '' ?>">
            </div>

            <div class="col-md-3 mb-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Aplicar</button>
                <a href="/ordem-servico/consultar" class="btn btn-secondary">Limpar</a>
            </div>
        </div>

    </form>

    <div style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark sticky-header">
                <tr>
                    <th>N° OS</th>
                    <th>Cliente</th>
                    <th>Placa</th>
                    <th>Dt Abertura</th>
                    <th>Dt Fechamento</th>
                    <th>Dt Faturamento</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($ordensServico)): ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Nenhuma ordem de serviço encontrada.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($ordensServico as $os): ?>
                    <tr onclick='selecionarOrdemServicoConsulta(this, <?= json_encode($os) ?>)' style="cursor:pointer;">
                        <td><?= $os['id'] ?></td>
                        <td><?= $os['pessoaNome'] ?></td>
                        <td><?= $os['veiculoPlaca'] ?></td>

                        <td>
                            <?= !empty($os['dataAbertura']) ? date('d/m/Y', strtotime($os['dataAbertura'])) : '' ?>
                        </td>

                        <td>
                            <?= !empty($os['dataFechamento']) ? date('d/m/Y', strtotime($os['dataFechamento'])) : '' ?>
                        </td>

                        <td>
                            <?= !empty($os['dataFaturamento']) ? date('d/m/Y', strtotime($os['dataFaturamento'])) : '' ?>
                        </td>

                        <td>
                            <span class="status-<?= strtolower($os['status']) ?>"><?= $os['status'] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <button type="button" id="btnCancelar" class="btn btn-danger" disabled>
            Cancelar OS
        </button>

        <button type="button" id="btnFechar" class="btn btn-success" disabled>
            Fechar OS
        </button>

        <button type="button" id="btnReabrir" class="btn btn-warning" disabled>
            Reabrir OS
        </button>


        <button type="button" id="btnAbrirModalFaturamento" class="btn btn-dark" disabled data-bs-toggle="modal" data-bs-target="#modalFaturamento">
            Faturar OS
        </button>
    </div>

    <div class="modal fade" id="modalFaturamento" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Faturar Ordem de Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label>N° OS</label>
                            <input type="text" id="ordemServicoIdFaturamento" class="form-control campo-readonly" readonly>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Código</label>
                            <input type="text" id="pessoaIdfaturamentoConsulta" class="form-control campo-readonly" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label>Nome</label>
                            <input type="text" id="pessoaNomeFaturamentoConsulta" class="form-control campo-readonly" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label>Valor Total da OS</label>
                            <input type="text" id="valorTotalFaturamentoConsulta" class="form-control campo-readonly" readonly>
                        </div>

                        <div class="col-md-8 mb-2">
                            <label>Forma de Pagamento</label>
                            <select id="formaPagamentoIdConsulta" class="form-select">
                                <option value="">Selecione</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label>1° Vencimento</label>
                            <input type="date" id="primeiroVencimentoConsulta" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Qtd Parcelas</label>
                            <input type="number" id="quantidadeParcelasConsulta" class="form-control" value="1" min="1">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Prazo parcelas</label>
                            <input type="number" id="intervaloParcelaConsulta" class="form-control" value="30" min="1">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Fechar
                    </button>

                    <button type="button" class="btn btn-success" onclick="faturarOrdemServicoConsulta()">
                        Confirmar Faturamento
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script src="/assets/js/ordemServico/consulta.js"></script>
<?php require __DIR__ . '/../layout/footer.php'; ?>