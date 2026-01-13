<?php echo $this->include('header'); ?>

<style>
    .report-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .report-header {
        background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
        color: white;
        padding: 25px;
    }

    .report-header h4 {
        margin: 0;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stats-row {
        margin-bottom: 30px;
    }

    .stat-box {
        padding: 20px;
        border-radius: 12px;
        height: 100%;
        transition: transform 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-label {
        font-size: 12px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.8);
        font-weight: bold;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 800;
        display: block;
        margin-top: 5px;
    }

    .bg-income {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
    }

    .bg-expense {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .bg-balance {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
        color: white;
    }

    .table-premium {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table-premium thead th {
        border: none;
        background: transparent;
        color: #7f8c8d;
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 700;
    }

    .table-premium tbody tr {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        transition: all 0.2s;
    }

    .table-premium tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .table-premium td {
        border: none;
        padding: 15px;
        vertical-align: middle;
    }

    .table-premium td:first-child {
        border-radius: 10px 0 0 10px;
    }

    .table-premium td:last-child {
        border-radius: 0 10px 10px 0;
    }

    .category-badge {
        background: #fdf2e9;
        color: #e67e22;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid #fad7a0;
    }

    .filter-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px dashed #dee2e6;
    }
</style>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card report-card">
            <div class="report-header d-flex justify-content-between align-items-center">
                <div>
                    <h4>Resumo de Caixa - <small style="color: #fff;"><?= $mes_extenso ?></small></h4>
                </div>
                <div class="d-print-none">
                    <a href="<?= base_url('relatorios/gerar-pdf-resumo-caixa?' . (isset($referencia_inicio) && isset($referencia_fim) ? 'referencia_inicio=' . $referencia_inicio . '&referencia_fim=' . $referencia_fim : 'referencia=' . $referencia)) ?>"
                        class="btn btn-warning btn-sm ml-2" target="_blank">
                        <i class="mdi mdi-file-pdf"></i> Exportar PDF
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <form method="get" class="form-inline d-print-none filter-section">
                    <div class="form-group mr-3">
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
                    <button type="submit" class="btn btn-primary btn-sm btn-rounded px-4">Filtrar Relatório</button>
                </form>

                <!-- Cards de Resumo -->
                <div class="row stats-row">
                    <div class="col-md-4 mb-3">
                        <div class="stat-box bg-income">
                            <span class="stat-label">Total Arrecadado</span>
                            <span class="stat-value">R$ <?= number_format($total_entradas, 2, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-box bg-expense">
                            <span class="stat-label">Total de Despesas</span>
                            <span class="stat-value">R$ <?= number_format($total_saidas, 2, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="stat-box bg-balance">
                            <span class="stat-label">Saldo em Caixa</span>
                            <span class="stat-value">R$
                                <?= number_format($total_entradas - $total_saidas, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Entradas Consolidadas -->
                    <div class="col-md-5 mb-4">
                        <h5 class="font-weight-bold text-dark mb-3"><i class="mdi mdi-trending-up text-success"></i>
                            Receitas (Consolidado)</h5>
                        <div class="table-responsive">
                            <table class="table table-premium">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entradas as $entrada): ?>
                                        <tr>
                                            <td><strong><?= $entrada->descricao ?></strong></td>
                                            <td class="text-right text-success font-weight-bold">R$
                                                <?= number_format($entrada->total, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Saídas Detalhadas -->
                    <div class="col-md-7">
                        <h5 class="font-weight-bold text-dark mb-3"><i class="mdi mdi-trending-down text-danger"></i>
                            Despesas (Detalhamento)</h5>
                        <div class="table-responsive">
                            <table class="table table-premium">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Categoria</th>
                                        <th>Observação</th>
                                        <th class="text-right">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($saidas_detalhe as $detalhe): ?>
                                        <tr>
                                            <td><small
                                                    class="text-muted"><?= date('d/m/Y', strtotime($detalhe->data_pagamento)) ?></small>
                                            </td>
                                            <td><span class="category-badge"><?= $detalhe->categoria ?></span></td>
                                            <td><?= $detalhe->observacao ?></td>
                                            <td class="text-right font-weight-bold text-danger">R$
                                                <?= number_format($detalhe->valor, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>