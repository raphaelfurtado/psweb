<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Prestação de Contas - <?= $mes_extenso ?></title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
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
            margin-bottom: 60px;
        }

        .title-group {
            margin-top: 40px;
        }

        .main-title {
            font-size: 32px;
            color: #d4af37;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 2px;
        }

        .sub-title {
            font-size: 28px;
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

        .logo-box img {
            width: 120px;
        }

        .logo-text {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-top: 5px;
            font-weight: bold;
        }

        .logo-desc {
            font-size: 14px;
            color: #333;
            font-weight: bold;
            display: block;
        }

        /* Intro text */
        .intro-section {
            margin-bottom: 30px;
        }

        .intro-title {
            font-size: 22px;
            color: #000;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .intro-text {
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        /* Table Style */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #e67e22;
            color: #fff;
            padding: 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            border: 1px solid #d35400;
        }

        td {
            padding: 10px;
            border: 1px solid #eee;
            font-size: 13px;
        }

        .total-row {
            background-color: #fff;
            font-weight: bold;
            border-top: 2px solid #e67e22;
        }

        .total-label {
            color: #333;
            text-transform: uppercase;
            padding-left: 10px;
        }

        .total-value {
            text-align: right;
            color: #000;
            padding-right: 10px;
        }

        .currency {
            font-weight: normal;
            margin-right: 5px;
        }

        .obs-footer {
            color: #e74c3c;
            font-weight: bold;
            margin-top: 15px;
            font-size: 12px;
        }

        .section-break {
            margin-top: 40px;
            page-break-before: always;
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
                <h1 class="main-title">PRESTAÇÃO DE CONTAS</h1>
                <h2 class="sub-title"><?= $mes_extenso ?></h2>
            </div>

            <div class="logo-box">
                <div style="background: rgba(255,255,255,0.7); padding: 10px; border-radius: 10px;">
                    <small class="logo-text">Loteamento</small>
                    <span class="logo-desc">PORTA DO SOL</span>
                </div>
            </div>
        </div>

        <div class="intro-section">
            <h3 class="intro-title">Saídas</h3>
            <p class="intro-text">
                Prezados (a) moradores (a), segue prestação de contas referente ao mês de
                <?= strtolower($mes_extenso) ?>.
                Qualquer dúvida estamos a disposição para esclarecimentos.
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="70%">DESCRIÇÃO</th>
                    <th width="30%" style="text-align: right;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($despesas_detalhe as $despesa): ?>
                    <tr>
                        <td><?= $despesa->categoria ?> - <?= $despesa->observacao ?></td>
                        <td style="text-align: right;">
                            <span class="currency">R$</span>
                            <strong><?= number_format($despesa->valor, 2, ',', '.') ?></strong>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td class="total-label">TOTAL DE SAÍDAS NO MÊS</td>
                    <td class="total-value">
                        <span class="currency">R$</span>
                        <strong><?= number_format($total_despesas, 2, ',', '.') ?></strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        <p class="obs-footer">OBS: À disposição para qualquer esclarecimento</p>

        <!-- Seção de Receitas na próxima página ou abaixo se houver espaço -->
        <div class="section-break">
            <div class="intro-section">
                <h3 class="intro-title">Entradas</h3>
                <p class="intro-text">Resumo das receitas arrecadadas no período.</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="70%">CONTRIBUINTE / CATEGORIA</th>
                        <th width="30%" style="text-align: right;">VALOR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($receitas_detalhe as $receita): ?>
                        <tr>
                            <td><?= $receita->nome ?> (Qd: <?= $receita->quadra ?> / Cs: <?= $receita->numero ?>) -
                                <?= $receita->categoria ?></td>
                            <td style="text-align: right;">
                                <span class="currency">R$</span>
                                <strong><?= number_format($receita->valor, 2, ',', '.') ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row" style="border-top-color: #27ae60;">
                        <td class="total-label">TOTAL DE RECEITAS NO MÊS</td>
                        <td class="total-value">
                            <span class="currency">R$</span>
                            <strong><?= number_format($total_receitas, 2, ',', '.') ?></strong>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-left: 5px solid #d4af37;">
                <h4 style="margin: 0; color: #333;">SALDO FINAL DO PERÍODO</h4>
                <h2
                    style="margin: 10px 0 0 0; color: <?= ($total_receitas - $total_despesas >= 0) ? '#27ae60' : '#e74c3c' ?>;">
                    R$ <?= number_format($total_receitas - $total_despesas, 2, ',', '.') ?>
                </h2>
            </div>
        </div>
    </div>
</body>

</html>