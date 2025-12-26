<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Resumo de Caixa - <?= $mes_extenso ?></title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Background Shapes */
        .shapes {
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 300px;
            overflow: hidden;
            z-index: -1;
        }

        .shape-orange {
            position: absolute;
            top: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            background-color: #e67e22;
            transform: rotate(45deg);
        }

        .shape-yellow {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 250px;
            height: 250px;
            background-color: #f1c40f;
            transform: rotate(30deg);
            opacity: 0.8;
        }

        .container {
            padding: 40px;
            position: relative;
        }

        /* Header */
        .top-header {
            margin-bottom: 40px;
        }

        .title-group {
            margin-top: 20px;
        }

        .main-title {
            font-size: 28px;
            color: #d4af37;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 1px;
        }

        .sub-title {
            font-size: 24px;
            color: #d4af37;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0 0 0;
        }

        .logo-box {
            position: absolute;
            top: 40px;
            right: 40px;
            text-align: right;
        }

        .logo-text {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 2px;
            font-weight: bold;
        }

        .logo-desc {
            font-size: 12px;
            color: #333;
            font-weight: bold;
            display: block;
        }

        /* Summary Boxes */
        .summary-grid {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin-left: -10px;
        }

        .summary-box {
            padding: 15px;
            border-radius: 8px;
            color: white;
            text-align: center;
        }

        .bg-green {
            background-color: #27ae60;
        }

        .bg-red {
            background-color: #e74c3c;
        }

        .bg-blue {
            background-color: #2980b9;
        }

        .summary-label {
            font-size: 10px;
            text-transform: uppercase;
            opacity: 0.9;
            font-weight: bold;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-top: 5px;
        }

        /* Table Style */
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            margin: 20px 0 10px 0;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #e67e22;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border: 1px solid #eee;
            font-size: 11px;
        }

        .total-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        .obs-footer {
            color: #e74c3c;
            font-weight: bold;
            margin-top: 20px;
            font-size: 11px;
            text-align: center;
        }

        .footer-info {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="shapes">
        <div class="shape-orange"></div>
        <div class="shape-yellow"></div>
    </div>

    <div class="container">
        <div class="top-header">
            <div class="title-group">
                <h1 class="main-title">RESUMO DE CAIXA</h1>
                <h2 class="sub-title"><?= $mes_extenso ?></h2>
            </div>

            <div class="logo-box">
                <div style="background: rgba(255,255,255,0.7); padding: 8px; border-radius: 8px;">
                    <small class="logo-text">Loteamento</small>
                    <span class="logo-desc">PORTA DO SOL</span>
                </div>
            </div>
        </div>

        <table class="summary-grid">
            <tr>
                <td class="summary-box bg-green" width="33%">
                    <span class="summary-label">Total Receitas</span>
                    <span class="summary-value">R$ <?= number_format($total_entradas, 2, ',', '.') ?></span>
                </td>
                <td class="summary-box bg-red" width="33%">
                    <span class="summary-label">Total Despesas</span>
                    <span class="summary-value">R$ <?= number_format($total_saidas, 2, ',', '.') ?></span>
                </td>
                <td class="summary-box bg-blue" width="33%">
                    <span class="summary-label">Saldo Final</span>
                    <span class="summary-value">R$
                        <?= number_format($total_entradas - $total_saidas, 2, ',', '.') ?></span>
                </td>
            </tr>
        </table>

        <div class="section-title">Resumo de Receitas (Consolidado)</div>
        <table>
            <thead>
                <tr>
                    <th width="15%">Cód</th>
                    <th width="55%">Descrição da Categoria</th>
                    <th width="30%" style="text-align: right;">Total Acumulado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entradas as $entrada): ?>
                    <tr>
                        <td><?= $entrada->codigo ?></td>
                        <td><strong><?= $entrada->descricao ?></strong></td>
                        <td style="text-align: right;">R$ <?= number_format($entrada->total, 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="section-title">Detalhamento de Saídas (Despesas)</div>
        <table>
            <thead>
                <tr>
                    <th width="12%">Data</th>
                    <th width="20%">Categoria</th>
                    <th width="53%">Descrição / Observação</th>
                    <th width="15%" style="text-align: right;">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saidas_detalhe as $detalhe): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($detalhe->data_pagamento)) ?></td>
                        <td><?= $detalhe->categoria ?></td>
                        <td><?= $detalhe->observacao ?></td>
                        <td style="text-align: right;"><strong>R$
                                <?= number_format($detalhe->valor, 2, ',', '.') ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right; padding: 12px;">TOTAL GERAL DE DESPESAS NO PERÍODO</td>
                    <td style="text-align: right; color: #e74c3c; font-size: 13px;">R$
                        <?= number_format($total_saidas, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>

        <p class="obs-footer">OBS: Comunicado oficial disponível para consulta administrativa.</p>
    </div>

    <div class="footer-info">
        PSWEB - Gestão Inteligente | Emitido em <?= date('d/m/Y H:i') ?>
    </div>
</body>

</html>