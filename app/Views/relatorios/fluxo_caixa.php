<?php echo $this->include('header'); ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Fluxo de Caixa - Ref: <?= $referencia ?></h4>

                <form method="get" class="form-inline mb-4">
                    <div class="form-group mr-2">
                        <label class="mr-2">Mês/Ano:</label>
                        <select name="referencia" class="form-control">
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes ?>" <?= ($mes == $referencia) ? 'selected' : '' ?>><?= $mes ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>Entradas (Receitas)</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th class="text-right">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalEntradas = 0;
                                    foreach ($entradas as $entrada):
                                        $totalEntradas += $entrada->total;
                                        ?>
                                        <tr>
                                            <td><?= $entrada->descricao ?></td>
                                            <td class="text-right">R$ <?= number_format($entrada->total, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>TOTAL ENTRADAS</td>
                                        <td class="text-right">R$ <?= number_format($totalEntradas, 2, ',', '.') ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Saídas (Despesas)</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th class="text-right">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalSaidas = 0;
                                    foreach ($saidas as $saida):
                                        $totalSaidas += $saida->total;
                                        ?>
                                        <tr>
                                            <td><?= $saida->descricao ?: 'Não Categorizado' ?></td>
                                            <td class="text-right">R$ <?= number_format($saida->total, 2, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="font-weight-bold">
                                        <td>TOTAL SAÍDAS</td>
                                        <td class="text-right">R$ <?= number_format($totalSaidas, 2, ',', '.') ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div
                            class="alert <?= ($totalEntradas - $totalSaidas >= 0) ? 'alert-success' : 'alert-danger' ?> d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">SALDO LÍQUIDO DO MÊS</h4>
                            <h3 class="mb-0">R$ <?= number_format($totalEntradas - $totalSaidas, 2, ',', '.') ?></h3>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button onclick="window.print()" class="btn btn-light"><i class="mdi mdi-printer"></i>
                        Imprimir</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>