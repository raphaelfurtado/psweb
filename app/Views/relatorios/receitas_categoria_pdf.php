<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Receitas por Categoria - <?= $referencia ?></title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #f0ad4e;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #856404;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th {
            background-color: #fcf8e3;
            border: 1px solid #ddd;
            padding: 12px 8px;
            text-align: left;
            color: #856404;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .badge {
            background-color: #333;
            color: white;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .footer-table {
            background-color: #f9f9f9;
        }

        .total-label {
            text-align: right;
            background-color: #eee;
            font-weight: bold;
        }

        .total-value {
            text-align: right;
            color: #007bff;
            font-size: 15px;
            font-weight: bold;
        }

        .footer-info {
            text-align: center;
            font-size: 10px;
            color: #999;
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Resumo de Receitas por Categoria</h1>
        <p>Mês de Referência: <strong><?= $referencia ?></strong> | Emitido em: <?= date('d/m/Y H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%">Cód.</th>
                <th width="50%">Descrição da Categoria</th>
                <th class="text-center" width="15%">Lançamentos</th>
                <th class="text-right" width="25%">Valor Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agrupado as $item): ?>
                <tr>
                    <td class="text-center"><span class="badge"><?= $item->codigo ?></span></td>
                    <td class="font-bold"><?= $item->descricao ?></td>
                    <td class="text-center"><?= $item->quantidade ?></td>
                    <td class="text-right font-bold">R$ <?= number_format($item->total, 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="footer-table">
                <td colspan="2" class="total-label border-0">TOTAIS CONSOLIDADOS DO MÊS:</td>
                <td class="text-center font-bold border-0"><?= $qtd_geral ?></td>
                <td class="total-value border-0">R$ <?= number_format($total_geral, 2, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer-info">
        PSWEB - Gestão Inteligente de Loteamentos | Relatório de Transparência Administrativa
    </div>
</body>

</html>