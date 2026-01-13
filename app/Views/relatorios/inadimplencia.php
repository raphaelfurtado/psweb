<?php echo $this->include('header'); ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Relatório de Inadimplência</h4>

                <form method="get" class="form-inline mb-4 d-print-none">
                    <div class="form-group mr-2">
                        <label class="mr-2">De:</label>
                        <select name="referencia_inicio" class="form-control mr-3">
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes ?>" <?= ($mes == ($referencia_inicio ?? $referencia)) ? 'selected' : '' ?>><?= $mes ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label class="mr-2">Até:</label>
                        <select name="referencia_fim" class="form-control">
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes ?>" <?= ($mes == ($referencia_fim ?? $referencia)) ? 'selected' : '' ?>><?= $mes ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <label class="mr-2">Quadra:</label>
                        <input type="number" name="quadra" class="form-control" value="<?= $quadra ?>"
                            placeholder="Todas">
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <!-- <a href="<?= base_url('relatorios/gerar-pdf-inadimplencia?' . (isset($referencia_inicio) && isset($referencia_fim) ? 'referencia_inicio=' . $referencia_inicio . '&referencia_fim=' . $referencia_fim : 'referencia=' . $referencia)) ?>"
                        class="btn btn-warning ml-2" target="_blank">
                        <i class="mdi mdi-file-pdf"></i> Exportar PDF
                    </a> -->
                </form>

                <div class="table-responsive mt-4">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Morador</th>
                                <th>Telefone</th>
                                <th>Quadra</th>
                                <th>Casa</th>
                                <th>Vencimento</th>
                                <th>Situação</th>
                                <th class="text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalEmAberto = 0;
                            foreach ($inadimplentes as $item):
                                $totalEmAberto += $item->valor;
                                ?>
                                <tr>
                                    <td><?= $item->nome ?></td>
                                    <td><?= $item->telefone ?></td>
                                    <td><?= $item->quadra ?></td>
                                    <td><?= $item->numero ?></td>
                                    <td><?= date('d/m/Y', strtotime($item->data_vencimento)) ?></td>
                                    <td>
                                        <label
                                            class="badge badge-<?= ($item->situacao == 'ABERTO') ? 'info' : 'warning' ?>">
                                            <?= $item->situacao ?>
                                        </label>
                                    </td>
                                    <td class="text-right">R$ <?= number_format($item->valor, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold bg-light">
                                <td colspan="6" class="text-right">TOTAL EM ABERTO:</td>
                                <td class="text-right">R$ <?= number_format($totalEmAberto, 2, ',', '.') ?></td>
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