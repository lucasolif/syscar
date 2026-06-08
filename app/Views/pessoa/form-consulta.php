<?php require __DIR__ . '/../layout/header.php'; ?>

    <h2>Consulta de Pessoas</h2>

    <form method="get" action="/pessoa/consultar" class="mb-4">

        <div class="row">
            <div class="col-md-1 mb-1">
                <label>Código</label>
                <input type="text" name="id" class="form-control" value="<?= $_GET['id'] ?? '' ?>">
            </div>

            <div class="col-md-3 mb-2">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= $_GET['nome'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>CPF</label>
                <input type="text" name="cpf" class="form-control" value="<?= $_GET['cpf'] ?? '' ?>">
            </div>
            <div class="col-md-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Aplicar</button>
                <a href="/pessoa/consultar" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>

    <div style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="table-dark sticky-header">
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Data Nascimento</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>
            <?php if (empty($pessoas)): ?>
                <tr>
                    <td colspan="14" class="text-center">
                        Nenhuma pessoa encontrada.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($pessoas as $pessoa): ?>
                <tr>
                    <td><?= $pessoa['id'] ?></td>
                    <td><?= $pessoa['nome'] ?></td>
                    <td><?= $pessoa['cpf'] ?></td>
                    <td><?= $pessoa['telefone'] ?></td>
                    <td><?= $pessoa['email'] ?></td>
                    <td>
                        <?= !empty($pessoa['dataNascimento'])
                            ? date('d/m/Y', strtotime($pessoa['dataNascimento']))
                            : '' ?>
                    </td>
                    <td>
                        <?php if ($pessoa['ativo']): ?>
                            <span class="badge bg-success">Ativo</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Inativo</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php require __DIR__ . '/../layout/footer.php'; ?>