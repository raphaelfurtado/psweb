<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto p-4">

    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

   <?php if (!empty($msg)): ?>
    <strong 
        class="block mb-4 <?php echo $msg['type'] === 'success' ? 'text-green-600' : 'text-red-600'; ?>">
        <?php echo $msg['text']; ?>
    </strong>
<?php endif; ?>

    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
    </p>

    <form method="post" class="space-y-4 bg-white p-6 rounded shadow">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="nome" class="block font-medium">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo (isset($usuario) ? $usuario->nome : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label for="aniversario" class="block font-medium">Aniversário:</label>
                <input type="date" id="aniversario" name="aniversario"
                    value="<?php echo (isset($usuario) ? $usuario->aniversario : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="telefone" class="block font-medium">Telefone:</label>
                <input type="text" id="telefone" name="telefone"
                    value="<?php echo (isset($usuario) ? $usuario->telefone : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label for="telefone_2" class="block font-medium">Telefone 2:</label>
                <input type="text" id="telefone_2" name="telefone_2"
                    value="<?php echo (isset($usuario) ? $usuario->telefone_2 : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <label for="rua" class="block font-medium">Rua:</label>
                <input type="text" id="rua" name="rua" value="<?php echo (isset($endereco) ? $endereco->rua : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label for="quadra" class="block font-medium">Quadra:</label>
                <input type="text" id="quadra" name="quadra"
                    value="<?php echo (isset($endereco) ? $endereco->quadra : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label for="numero" class="block font-medium">Número:</label>
                <input type="text" id="numero" name="numero"
                    value="<?php echo (isset($endereco) ? $endereco->numero : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label for="qtd_lote" class="block font-medium">Qtd Lote:</label>
                <input type="number" id="qtd_lote" name="qtd_lote"
                    value="<?php echo (isset($endereco) ? $endereco->qtd_lote : '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="relative">
                <label for="senha" class="block font-medium">Senha:</label>
                <input type="password" id="senha" name="senha"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    placeholder="Deixe em branco para não alterar a senha">
                <span id="toggleSenha" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                    👁️
                </span>
            </div>
        </div>

        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                <?php echo $acao ?>
            </button>
        </div>
    </form>

    <?php if ($acao != "Inserir"): ?>
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Lista de Pagamentos de <?php echo $usuario->nome ?></h2>

            <div class="overflow-x-auto">
                <table class="table-auto w-full bg-white shadow-md rounded">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Cód. Pagto</th>
                            <th class="px-4 py-2">Morador</th>
                            <th class="px-4 py-2">Recebedor</th>
                            <th class="px-4 py-2">Número</th>
                            <th class="px-4 py-2">Quadra</th>
                            <th class="px-4 py-2">Data Pagamento</th>
                            <th class="px-4 py-2">Referência</th>
                            <th class="px-4 py-2">Valor</th>
                            <th class="px-4 py-2">Desc. Pagto</th>
                            <th class="px-4 py-2">Observação</th>
                            <th class="px-4 py-2">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pagamentos)): ?>
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
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center py-4">Nenhum registro encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="mt-4">
                <?php echo $pager->links(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php echo $this->include('footer'); ?>