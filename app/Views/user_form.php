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
                <table id="dataTablePagamentos" class="datatable table-auto w-full bg-white shadow-md rounded">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 text-left">Cód.</th>
                            <th class="px-4 py-2 text-left">Morador</th>
                            <th class="px-4 py-2 text-left">Recebedor</th>
                            <th class="px-4 py-2 text-left">Quadra</th>
                            <th class="px-4 py-2 text-left">Número</th>
                            <th class="px-4 py-2 text-left">Data Pagamento</th>
                            <th class="px-4 py-2 text-left">Referência</th>
                            <th class="px-4 py-2 text-left">Valor</th>
                            <th class="px-4 py-2 text-left">Situação</th>
                            <th class="px-4 py-2 text-left">Tipo Pagto</th>
                            <th class="px-4 py-2 text-left">Obs</th>
                            <th class="px-4 py-2 text-left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pagamentos as $pagamento): ?>
                            <?php
                            $situacaoClass = '';
                            if ($pagamento->situacao === 'PAGO') {
                                $situacaoClass = 'px-4 py-2 bg-green-100 text-green-700 font-bold rounded-full';
                            } elseif ($pagamento->situacao === 'PENDENTE') {
                                $situacaoClass = 'px-4 py-2 bg-yellow-100 text-yellow-700 font-bold rounded-full';
                            } elseif ($pagamento->situacao === 'CANCELADO') {
                                $situacaoClass = 'px-4 py-2 bg-red-100 text-red-700 font-bold rounded-full';
                            } elseif ($pagamento->situacao === 'ABERTO') {
                                $situacaoClass = 'px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-full';
                            }
                            ?>
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-4 py-2"><?php echo $pagamento->id_pagamento ?></td>
                                <td class="px-4 py-2"><?php echo $pagamento->nome_morador ?></td>
                                <td class="px-4 py-2"><?php echo $pagamento->nome_recebedor ?></td>
                                <td class="px-4 py-2"><?php echo $pagamento->quadra ?></td>
                                <td class="px-4 py-2"><?php echo $pagamento->numero ?></td>
                                <td class="px-4 py-2"><?php echo date('d/m/Y', strtotime($pagamento->data_pagamento)) ?></td>
                                <td class="px-4 py-2"><?php echo $pagamento->referencia ?></td>
                                <td class="px-4 py-2"><?php echo $pagamento->valor ?></td>
                                <td class="px-4 py-2"><span class="<?= $situacaoClass; ?>"><?php echo $pagamento->situacao ?></span></td>
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
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php echo $this->include('footer'); ?>