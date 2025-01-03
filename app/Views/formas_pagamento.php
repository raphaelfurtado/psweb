<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
    </p>

    <div class="overflow-x-auto">
        <table class="datatable table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Código</th>
                    <th class="px-4 py-2 text-left">Descricao</th>
                    <th class="px-4 py-2 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($formasPagamento as $formaPagamento): ?>
                    <tr class="border-t hover:bg-gray-100">
                        <td class="px-4 py-2"><?php echo $formaPagamento->id ?></td>
                        <td class="px-4 py-2"><?php echo $formaPagamento->codigo ?></td>
                        <td class="px-4 py-2"><?php echo $formaPagamento->descricao ?></td>
                        <td class="px-4 py-2">
                            <a href="<?php echo base_url('/formaPagamento/editar/' . $formaPagamento->id) ?>"
                                class="text-blue-500 hover:underline">
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php echo $this->include('footer'); ?>