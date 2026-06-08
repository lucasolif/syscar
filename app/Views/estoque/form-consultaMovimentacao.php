<?php require __DIR__ . '/../layout/header.php'; ?>

    <h2>Consulta de Movimentações do Estoque</h2>

    <form method="get" action="/estoque/consultar-movimentacao" class="mb-4">

        <div class="row">

            <div class="col-md-1 mb-3">
                <label>Código</label>
                <input type="text" name="produtoId" class="form-control" value="<?= $_GET['produtoId'] ?? '' ?>">
            </div>

            <div class="col-md-3 mb-3">
                <label>Nome do Produto</label>
                <input type="text" name="nome" class="form-control" value="<?= $_GET['nome'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-3">
                <label>Tipo</label>
                <select name="tipoMovimento" class="form-select">
                    <option value="">Todos</option>
                    <option value="ENTRADA"
                        <?= ($_GET['tipoMovimento'] ?? '') === 'ENTRADA' ? 'selected' : '' ?>>
                        Entrada
                    </option>
                    <option value="SAIDA"
                        <?= ($_GET['tipoMovimento'] ?? '') === 'SAIDA' ? 'selected' : '' ?>>
                        Saída
                    </option>
                </select>
            </div>

            <div class="col-md-2 mb-3">
                <label>Origem</label>
                <select name="origem" class="form-select">
                    <option value="">Todas</option>
                    <option value="AVULSO"
                        <?= ($_GET['origem'] ?? '') === 'AVULSO' ? 'selected' : '' ?>>
                        Avulso
                    </option>
                    <option value="OS"
                        <?= ($_GET['origem'] ?? '') === 'OS' ? 'selected' : '' ?>>
                        OS
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="d-block">&nbsp;</label>

                <button type="submit" class="btn btn-primary">
                    Aplicar
                </button>

                <a href="/estoque/consultar-movimentacao"
                   class="btn btn-secondary">
                    Limpar
                </a>
            </div>

        </div>

    </form>
    <div style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="table-dark sticky-header">
            <tr>
                <th>Cod Produto</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Origem</th>
                <th>OS</th>
                <th>Data Movimento</th>
            </tr>
            </thead>

            <tbody>

            <?php if (empty($movimentacoes)): ?>
                <tr>
                    <td colspan="8" class="text-center">
                        Nenhuma movimentação encontrada.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($movimentacoes as $movimentacao): ?>
                <tr>
                    <td><?= $movimentacao['produtoId'] ?></td>
                    <td><?= $movimentacao['produtoNome'] ?></td>
                    <td><?= $movimentacao['tipoMovimento'] ?></td>
                    <td><?= $movimentacao['quantidade'] ?></td>
                    <td><?= $movimentacao['origem'] ?></td>
                    <td><?= $movimentacao['ordemServicoId'] ?? ' ' ?></td>
                    <td>
                        <?= !empty($movimentacao['dataMovimento'])
                            ? date('d/m/Y', strtotime($movimentacao['dataMovimento']))
                            : '' ?>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
<?php require __DIR__ . '/../layout/footer.php'; ?>