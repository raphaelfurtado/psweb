<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto p-4">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
        <a href="<?php echo base_url($link) ?>"
            class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 text-center">
            <?php echo $tituloRedirect ?>
        </a>

        <!-- Formulário de Pesquisa -->
        <form method="get" action="<?php echo base_url('/users') ?>"
            class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <input type="text" name="nome" id="nome" value="<?php echo isset($nome) ? $nome : '' ?>"
                class="border border-gray-300 rounded px-2 py-1 flex-1 sm:flex-none" placeholder="Pesquisar por Nome">
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded hover:bg-purple-700">
                Buscar
            </button>
        </form>
    </div>

    <!-- Tabela -->
    <div class="overflow-x-auto">
        <table id="dataTableMoradores" class="datatable table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <!-- <th class="px-4 py-2">Código</th> -->
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Ações</th>
                    <th class="px-4 py-2">Rua</th>
                    <th class="px-4 py-2">Número</th>
                    <th class="px-4 py-2">Quadra</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($moradores)): ?>
                    <?php foreach ($moradores as $morador): ?>
                        <tr class="border-t hover:bg-gray-100">
                            <!-- <td class="px-4 py-2"><?php //echo $morador->id 
                                                        ?></td> -->
                            <td class="px-4 py-2"><?php echo $morador->nome ?></td>
                            <td class="px-4 py-2"><?php echo $morador->rua ?? 'Não informado'; ?></td>
                            <td class="px-4 py-2"><?php echo $morador->numero ?? 'Não informado'; ?></td>
                            <td class="px-4 py-2"><?php echo $morador->quadra ?? 'Não informado'; ?></td>
                            <td class="px-4 py-2">
                                <a href="<?php echo base_url('/user/editar/' . $morador->id) ?>"
                                    class="text-blue-500 hover:underline">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-4">Nenhum morador encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="bg-gray-200 font-bold">
                    <td class="px-4 py-2">Total de Moradores</td>
                    <td class="px-4 py-2" id="totalMoradores"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php echo $this->include('footer'); ?>