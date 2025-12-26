<?php echo $this->include('header'); ?>

<style>
    @media print {
        .card {
            border: none !important;
        }

        .card-body {
            padding: 0 !important;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .btn,
        .form-inline,
        .sidebar,
        .navbar {
            display: none !important;
        }

        .main-panel {
            width: 100% !important;
            padding: 0 !important;
        }

        .content-wrapper {
            padding: 0 !important;
        }
    }
</style>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="card-title mb-0">Prestação de Contas Detalhada - Ref: <?= $referencia ?></h3>
                </div>

                <form method="get" class="form-inline mb-4 d-print-none">
                    <div class="form-group mr-2">
                        <label class="mr-2">Mês/Ano:</label>
                        <select name="referencia" class="form-control">
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes ?>" <?= ($mes == $referencia) ? 'selected' : '' ?>><?= $mes ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <button type="button" onclick="window.print()" class="btn btn-success ml-2">
                        <i class="mdi mdi-printer"></i> Imprimir
                    </button>
                    <a href="<?= base_url('relatorios/gerar-pdf-prestacao?referencia=' . $referencia) ?>"
                        class="btn btn-info ml-2" target="_blank">
                        <i class="mdi mdi-file-pdf"></i> Exportar DOMPDF
                    </a>
                </form>

                <!-- Resumo Geral -->
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3 text-center">
                                <p class="text-muted mb-1">Total de Entradas</p>
                                <h4 class="text-success mb-0">R$ <?= number_format($total_receitas, 2, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3 text-center">
                                <p class="text-muted mb-1">Total de Saídas</p>
                                <h4 class="text-danger mb-0">R$ <?= number_format($total_despesas, 2, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border">
                            <div class="card-body p-3 text-center">
                                <p class="text-muted mb-1">Saldo Líquido</p>
                                <h4
                                    class="<?= ($total_receitas - $total_despesas >= 0) ? 'text-primary' : 'text-danger' ?> mb-0">
                                    R$ <?= number_format($total_receitas - $total_despesas, 2, ',', '.') ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalhamento de Saídas (O Ponto Principal) -->
                <div class="mb-5">
                    <h4 class="bg-danger text-white p-2">DETALHAMENTO DE DESPESAS (O QUE SAIU)</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable" style="width: 100%;">
                            <thead>
                                <tr class="bg-light">
                                    <th>Data</th>
                                    <th>Favorecido (Funcionário/Prestador)</th>
                                    <th>Categoria</th>
                                    <th>Descrição / Observação</th>
                                    <th class="text-right">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($despesas_detalhe as $despesa): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($despesa->data_pagamento)) ?></td>
                                        <td><strong><?= $despesa->favorecido ?></strong></td>
                                        <td><span
                                                class="badge badge-outline-danger"><?= $despesa->categoria ?: 'Geral' ?></span>
                                        </td>
                                        <td><small><?= $despesa->observacao ?></small></td>
                                        <td class="text-right">R$ <?= number_format($despesa->valor, 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="4" class="text-right">TOTAL DAS DESPESAS</td>
                                    <td class="text-right">R$ <?= number_format($total_despesas, 2, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Detalhamento de Entradas -->
                <div class="mb-4">
                    <h4 class="bg-success text-white p-2">DETALHAMENTO DE RECEITAS (O QUE ENTROU)</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped datatable" style="width: 100%;">
                            <thead>
                                <tr class="bg-light">
                                    <th>Data</th>
                                    <th>Morador</th>
                                    <th>Quadra/Casa</th>
                                    <th>Categoria</th>
                                    <th>Descrição / Observação</th>
                                    <th class="text-right">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($receitas_detalhe as $receita): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($receita->data_pagamento)) ?></td>
                                        <td><?= $receita->nome ?></td>
                                        <td>Qd: <?= $receita->quadra ?> / Casa: <?= $receita->numero ?></td>
                                        <td><span class="badge badge-outline-success"><?= $receita->categoria ?></span></td>
                                        <td><small><?= $receita->observacao ?></small></td>
                                        <td class="text-right">R$ <?= number_format($receita->valor, 2, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="font-weight-bold">
                                    <td colspan="5" class="text-right">TOTAL DAS RECEITAS</td>
                                    <td class="text-right">R$ <?= number_format($total_receitas, 2, ',', '.') ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>