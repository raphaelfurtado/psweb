<?php echo $this->include('header'); ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Relatório de Folha de Pagamento</h4>

                <form method="get" class="form-inline mb-4 d-print-none">
                    <div class="form-group mr-2">
                        <label class="mr-2">Referência:</label>
                        <select name="referencia" class="form-control">
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes ?>" <?= ($mes == $referencia) ? 'selected' : '' ?>><?= $mes ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>

                <div class="table-responsive mt-4">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Funcionário</th>
                                <th>Tipo</th>
                                <th>Data Pagto</th>
                                <th>Observação</th>
                                <th class="text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalPago = 0;
                            foreach ($pagamentos as $item):
                                $totalPago += $item->valor;
                                ?>
                                <tr>
                                    <td><?= $item->nome_completo ?></td>
                                    <td><?= $item->tipo ?: 'Não Especificado' ?></td>
                                    <td><?= date('d/m/Y', strtotime($item->data_pagamento)) ?></td>
                                    <td><small><?= $item->observacao ?></small></td>
                                    <td class="text-right">R$ <?= number_format($item->valor, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="4" class="text-right">TOTAL DA FOLHA:</td>
                                <td class="text-right">R$ <?= number_format($totalPago, 2, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-4 d-print-none">
                    <button onclick="window.print()" class="btn btn-light"><i class="mdi mdi-printer"></i>
                        Imprimir</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>