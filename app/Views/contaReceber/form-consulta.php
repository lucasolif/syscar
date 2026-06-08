<?php require __DIR__ . '/../layout/header.php'; ?>

    <link rel="stylesheet" href="/assets/css/contaReceber.css">

    <div id="mensagem"></div>

    <h2>Contas a Receber</h2>

    <form method="get" action="/conta-receber/consultar" class="mb-4">

        <div class="row">
            <div class="col-md-2 mb-2">
                <label>Cliente</label>
                <input type="text" name="cliente" class="form-control" value="<?= $_GET['cliente'] ?? '' ?>">
            </div>

            <div class="col-md-1 mb-2">
                <label>N° OS</label>
                <input type="text" name="ordemServicoId" class="form-control" value="<?= $_GET['ordemServicoId'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Forma Pagamento</label>
                <select id="filtroFormaPagamentoId" name="formaPagamentoId" class="form-select">
                    <option value="">Todas</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="PENDENTE" <?= ($_GET['status'] ?? '') === 'PENDENTE' ? 'selected' : '' ?>>Pendente</option>
                    <option value="CANCELADA" <?= ($_GET['status'] ?? '') === 'CANCELADA' ? 'selected' : '' ?>>Cancelada</option>
                    <option value="PARCIAL" <?= ($_GET['status'] ?? '') === 'PARCIAL' ? 'selected' : '' ?>>Parcial</option>
                    <option value="PAGA" <?= ($_GET['status'] ?? '') === 'PAGA' ? 'selected' : '' ?>>Paga</option>
                </select>
            </div>

            <div class="col-md-2 mb-2">
                <label>Geração Inicial</label>
                <input type="date" name="dataGeracaoInicial" class="form-control" value="<?= $_GET['dataGeracaoInicial'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Geração Final</label>
                <input type="date" name="dataGeracaoFinal" class="form-control" value="<?= $_GET['dataGeracaoFinal'] ?? '' ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 mb-2">
                <label>Vencimento Inicial</label>
                <input type="date" name="dataVencimentoInicial" class="form-control" value="<?= $_GET['dataVencimentoInicial'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Vencimento Final</label>
                <input type="date" name="dataVencimentoFinal" class="form-control" value="<?= $_GET['dataVencimentoFinal'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Pagamento Inicial</label>
                <input type="date" name="dataPagamentoInicial" class="form-control" value="<?= $_GET['dataPagamentoInicial'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Pagamento Final</label>
                <input type="date" name="dataPagamentoFinal" class="form-control" value="<?= $_GET['dataPagamentoFinal'] ?? '' ?>">
            </div>

            <div class="col-md-3 mb-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Aplicar</button>
                <a href="/conta-receber/consultar" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

    <div style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="table-dark sticky-header">
            <tr>
                <th>N° Conta</th>
                <th>Cliente</th>
                <th>Dt Vencimento</th>
                <th>Dt Pagamento</th>
                <th>Parcela</th>
                <th>Valor</th>
                <th>Valor Pago</th>
                <th>Valor Pendente</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>
            <?php if (empty($contasReceber)): ?>
                <tr>
                    <td colspan="9" class="text-center">
                        Nenhuma conta a receber encontrada.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($contasReceber as $conta): ?>
                <tr onclick='selecionarContaReceber(this, <?= json_encode($conta) ?>)' style="cursor:pointer;">
                    <td><?= $conta['id'] ?></td>
                    <td><?= $conta['pessoaNome'] ?></td>

                    <td>
                        <?= !empty($conta['dataVencimento']) ? date('d/m/Y', strtotime($conta['dataVencimento'])) : '' ?>
                    </td>

                    <td>
                        <?= !empty($conta['dataPagamento']) ? date('d/m/Y', strtotime($conta['dataPagamento'])) : '' ?>
                    </td>

                    <td><?= $conta['parcela'] ?></td>
                    <td><?= number_format($conta['valor'], 2, ',', '.') ?></td>
                    <td><?= number_format($conta['valorPago'], 2, ',', '.') ?></td>
                    <td><?= number_format($conta['valorPendente'], 2, ',', '.') ?></td>

                    <td>
                        <span class="status-<?= strtolower($conta['status']) ?>">
                            <?= $conta['status'] ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <button type="button" id="btnCancelar" class="btn btn-danger" disabled>
            Cancelar
        </button>

        <button type="button" id="btnEstornarBaixa" class="btn btn-warning" disabled>
            Estornar Baixa
        </button>

        <button type="button" id="btnAbrirModalBaixa" class="btn btn-success" disabled data-bs-toggle="modal" data-bs-target="#modalBaixa">
            Baixar
        </button>
    </div>

    <div class="modal fade" id="modalBaixa" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Baixar Conta a Receber</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label>N° Conta</label>
                            <input type="text" id="contaReceberId" class="form-control campo-readonly" readonly>
                        </div>

                        <div class="col-md-2 mb-1">
                            <label>Parcela</label>
                            <input type="text" id="parcela" class="form-control campo-readonly" readonly>
                        </div>

                        <input type="hidden" id="pessoaId" class="form-control campo-readonly" readonly>

                        <div class="col-md-6 mb-2">
                            <label>Nome</label>
                            <input type="text" id="pessoaNome" class="form-control campo-readonly" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label>Valor Pendente</label>
                            <input type="text" id="valorPendente" class="form-control campo-readonly" readonly>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>Valor a Pagar</label>
                            <input type="text" id="valorPago" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Dt Pagamento</label>
                            <input type="date" id="dataPagamento" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label>Forma de Pagamento</label>
                            <select id="formaPagamentoId" class="form-select">
                                <option value="">Selecione</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Conta Caixa</label>
                            <select id="contaCaixaId" class="form-select">
                                <option value="">Selecione</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Fechar
                    </button>

                    <button type="button" class="btn btn-success" onclick="baixarContaReceber()">
                        Confirmar Baixa
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="/assets/js/contaReceber/consulta.js"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>