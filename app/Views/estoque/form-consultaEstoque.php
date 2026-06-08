<?php require __DIR__ . '/../layout/header.php'; ?>

    <h2>Consulta de Estoque</h2>

    <form method="get" action="/estoque/consultar" class="mb-4">

        <div class="row">
            <div class="col-md-1 mb-3">
                <label>Codigo</label>
                <input type="text" name="id" class="form-control" value="<?= $_GET['id'] ?? '' ?>">
            </div>

            <div class="col-md-3 mb-3">
                <label>Nome do Produto</label>
                <input type="text" name="nome" class="form-control" value="<?= $_GET['nome'] ?? '' ?>">
            </div>

            <div class="col-md-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Aplicar</button>
                <a href="/estoque/consultar" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

    <div style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="table-dark sticky-header">
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Marca</th>
                <th>Quantidade</th>
                <th>Última Movimentação</th>
            </tr>
            </thead>

            <tbody>
            <?php if (empty($estoque)): ?>
                <tr>
                    <td colspan="5" class="text-center">
                        Nenhum produto encontrado no estoque.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($estoque as $est): ?>
                <tr>
                    <td><?= $est['produtoId'] ?></td>
                    <td><?= $est['nome'] ?></td>
                    <td><?= $est['marca'] ?></td>
                    <td><?= $est['quantidade'] ?></td>
                    <td>
                        <?= !empty($est['dataMovimento'])
                            ? date('d/m/Y', strtotime($est['dataMovimento']))
                            : '' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php require __DIR__ . '/../layout/footer.php'; ?>