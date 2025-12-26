<?php echo $this->include('header'); ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Receitas Agrupadas por Categoria - Ref: <?= $referencia ?></h4>

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
                    <a href="<?= base_url('relatorios/gerar-pdf-receitas?referencia=' . $referencia) ?>" class="btn btn-warning ml-2" target="_blank">
                        <i class="mdi mdi-file-pdf"></i> Exportar PDF (DOMPDF)
                    </a>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">Cód.</th>
                                <th width="50%">Categoria (Tipo de Pagamento)</th>
                                <th class="text-center" width="15%">Qtd. Lançamentos</th>
                                <th class="text-right" width="25%">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalGeral = 0;
                            $qtdGeral = 0;
                            foreach ($agrupado as $item):
                                $totalGeral += $item->total;
                                $qtdGeral += $item->quantidade;
                                ?>
                                <tr>
                                    <td><span class="badge badge-dark"><?= $item->codigo ?></span></td>
                                    <td><strong><?= $item->descricao ?></strong></td>
                                    <td class="text-center"><?= $item->quantidade ?></td>
                                    <td class="text-right font-weight-bold">R$
                                        <?= number_format($item->total, 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light font-weight-bold">
                            <tr>
                                <td colspan="2" class="text-right">TOTAIS CONSOLIDADOS:</td>
                                <td class="text-center"><?= $qtdGeral ?></td>
                                <td class="text-right text-primary">R$ <?= number_format($totalGeral, 2, ',', '.') ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if (empty($agrupado)): ?>
                    <div class="alert alert-info mt-4">Nenhuma receita encontrada para a referência selecionada.</div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>