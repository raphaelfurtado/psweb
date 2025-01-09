<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
        <p class="text-green-700 font-semibold">
            <strong>Total em caixa</strong>: R$ <?= number_format($totalPago - $totalSaida, 2, ',', '.') ?>
        </p>
        <p class="text-blue-700 font-semibold">
            Total de saídas: R$ <?= number_format($totalSaida, 2, ',', '.') ?>
        </p>
    </p>
    
    <div class="overflow-x-auto">

        <table id="dataTablePagamentos" class="datatable table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Cód.</th>
                    <th class="px-4 py-2 text-left">Data Pagamento</th>
                    <th class="px-4 py-2 text-left">Valor</th>
                    <th class="px-4 py-2 text-left">Tipo Pagto</th>
                    <th class="px-4 py-2 text-left">Descrição</th>
                    <th class="px-4 py-2 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saidas as $saida): ?>
                    <tr class="border-t hover:bg-gray-100">
                        <td class="px-4 py-2"><?php echo $saida->id ?></td>
                        <td class="px-4 py-2"><?php echo date('d/m/Y', strtotime($saida->data_pagamento)) ?></td>
                        <td class="px-4 py-2">R$ <?php echo number_format($saida->valor, 2, ',', '.') ?></td>
                        <td class="px-4 py-2"><?php echo $saida->desc_pagamento ?></td>
                        <td class="px-4 py-2"><?php echo $saida->observacao ?></td>
                        <td class="px-4 py-2">
                            <a href="<?php echo base_url('/saida/editar/' . $saida->id) ?>"
                                class="text-blue-500 hover:underline">
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th id="totalValor"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>


<?php echo $this->include('template/footer'); ?>