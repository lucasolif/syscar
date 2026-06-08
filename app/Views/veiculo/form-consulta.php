<?php require __DIR__ . '/../layout/header.php'; ?>

    <h2>Consulta de Veículos</h2>

    <form method="get" action="/veiculo/consultar" class="mb-4">

        <div class="row">

            <div class="col-md-1 mb-1">
                <label>Código</label>
                <input type="text" name="id" class="form-control" value="<?= $_GET['id'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Modelo</label>
                <input type="text" name="modelo" class="form-control" value="<?= $_GET['modelo'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Placa</label>
                <input type="text" name="placa" class="form-control" value="<?= $_GET['placa'] ?? '' ?>">
            </div>
            <div class="col-md-2 mb-2">
                <label>Marca</label>
                <input type="text" name="marca" class="form-control" value="<?= $_GET['marca'] ?? '' ?>">
            </div>

            <div class="col-md-2 mb-2">
                <label>Tipo</label>

                <select name="tipo" class="form-select">
                    <option value="">Todos</option>

                    <option value="Moto"<?= ($_GET['tipo'] ?? '') === 'Moto' ? 'selected' : '' ?>>
                        Moto
                    </option>

                    <option value="Carro"<?= ($_GET['tipo'] ?? '') === 'Carro' ? 'selected' : '' ?>>
                        Carro
                    </option>

                    <option value="Ônibus"<?= ($_GET['tipo'] ?? '') === 'Ônibus' ? 'selected' : '' ?>>
                        Ônibus
                    </option>

                    <option value="Caminhão"<?= ($_GET['tipo'] ?? '') === 'Caminhão' ? 'selected' : '' ?>>
                        Caminhão
                    </option>

                    <option value="Carreta"<?= ($_GET['tipo'] ?? '') === 'Carreta' ? 'selected' : '' ?>>
                        Carreta
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Aplicar</button>
                <a href="/veiculo/consultar" class="btn btn-secondary">Limpar</a>
            </div>
        </div>

    </form>

    <div style="max-height: 520px; overflow-y: auto;">
        <table class="table table-bordered table-striped">
            <thead class="table-dark sticky-header">
            <tr>
                <th>Código</th>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Marca</th>
                <th>Cor</th>
                <th>Tipo</th>
                <th>Ano</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>

            <?php if (empty($veiculos)): ?>
                <tr>
                    <td colspan="8" class="text-center">
                        Nenhum veículo encontrado.
                    </td>
                </tr>
            <?php endif; ?>

            <?php foreach ($veiculos as $veiculo): ?>
                <tr>

                    <td><?= $veiculo['id'] ?></td>
                    <td><?= $veiculo['modelo'] ?></td>
                    <td><?= $veiculo['placa'] ?></td>
                    <td><?= $veiculo['marca'] ?></td>
                    <td><?= $veiculo['cor'] ?></td>
                    <td><?= $veiculo['tipo'] ?></td>
                    <td><?= $veiculo['ano'] ?></td>
                    <td>
                        <?php if ($veiculo['ativo']): ?>
                            <span class="badge bg-success">
                            Ativo
                        </span>
                        <?php else: ?>
                            <span class="badge bg-danger">
                            Inativo
                        </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php require __DIR__ . '/../layout/footer.php'; ?>