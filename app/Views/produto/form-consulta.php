<?php require __DIR__ . '/../layout/header.php'; ?>

    <h2>Consulta de Produtos</h2>

    <form method="get" action="/produto/consultar" class="mb-4">

        <div class="row">
            <div class="col-md-1 mb-1">
                <label>Código</label>
                <input type="text" name="id" class="form-control" value="<?= $_GET['id'] ?? '' ?>">
            </div>
            <div class="col-md-2 mb-1">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= $_GET['nome'] ?? '' ?>">
            </div>
            <div class="col-md-2 mb-2">
                <label>Marca</label>
                <input type="text" name="marca" class="form-control" value="<?= $_GET['marca'] ?? '' ?>">
            </div>
            <div class="col-md-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Aplicar</button>
                <a href="/produto/consultar" class="btn btn-secondary">Limpar</a>
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
                <th>Preço Custo</th>
                <th>Preço Venda</th>
                <th>Status</th>
                <th>Qtd. Estoque</th>
            </tr>
            </thead>

            <tbody>
            <?php if (empty($produtos)): ?>
                <tr>
                    <td colspan="7" class="text-center">
                        Nenhum produto encontrado.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto['id'] ?></td>
                    <td><?= $produto['nome'] ?></td>
                    <td><?= $produto['marca'] ?></td>
                    <td>R$ <?= number_format($produto['precoCusto'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($produto['precoVenda'], 2, ',', '.') ?></td>
                    <td>
                        <?php if ($produto['ativo']): ?>
                            <span class="badge bg-success">Ativo</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inativo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $produto['quantidade'] ?? 0 ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php require __DIR__ . '/../layout/footer.php'; ?>