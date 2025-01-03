<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
    </p>
    
    <div class="overflow-x-auto">

        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Cód. Pagto</th>
                    <th class="px-4 py-2 text-left">Morador</th>
                    <th class="px-4 py-2 text-left">Recebedor</th>
                    <th class="px-4 py-2 text-left">Número</th>
                    <th class="px-4 py-2 text-left">Quadra</th>
                    <th class="px-4 py-2 text-left">Data Pagamento</th>
                    <th class="px-4 py-2 text-left">Referência</th>
                    <th class="px-4 py-2 text-left">Valor</th>
                    <th class="px-4 py-2 text-left">Desc. Pagto</th>
                    <th class="px-4 py-2 text-left">Observação</th>
                    <th class="px-4 py-2 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagamentos as $pagamento): ?>
                    <tr class="border-t hover:bg-gray-100">
                        <td class="px-4 py-2"><?php echo $pagamento->id_pagamento ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->nome_morador ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->nome_recebedor ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->numero ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->quadra ?></td>
                        <td class="px-4 py-2"><?php echo date('d/m/Y', strtotime($pagamento->data_pagamento)) ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->referencia ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->valor ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->desc_pagamento ?></td>
                        <td class="px-4 py-2"><?php echo $pagamento->observacao ?></td>
                        <td class="px-4 py-2">
                            <a href="<?php echo base_url('/pagamento/editar/' . $pagamento->id_pagamento) ?>"
                                class="text-blue-500 hover:underline">
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <div class="mt-4">
            <div class="pagination-container text-center">
                <?php echo $pager->links(); ?>
            </div>
        </div>
    </div>
</div>


<?php echo $this->include('footer'); ?>