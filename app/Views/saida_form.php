<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

<strong class="text-lg text-red-500 mb-4 block"><?php echo $msg ?></strong>

<div id="content" class="max-w-4xl mx-auto p-4">


    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
    </p>
    <br />

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Total de Pagamentos</h2>
        <p class="text-green-700 font-semibold">
            <strong>Total em caixa</strong>: R$ <?= number_format($totalPago - $totalSaida, 2, ',', '.') ?>
        </p>
        <p class="text-blue-700 font-semibold">
            Total de saídas: R$ <?= number_format($totalSaida, 2, ',', '.') ?>
        </p>
    </div>

    <br />

    <form method="post" class="space-y-4">
        <div>
            <label for="tipoPagamento" class="block text-sm font-medium">Selecione um Tipo de Saída: (de onde está saindo o valor)</label>
            <select id="tipoPagamento" name="tipoPagamento" required
                class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                    <option value="<?= $tipoPagamento->codigo; ?>" <?= (isset($saida) && $saida->id_tipo_pagamento == $tipoPagamento->codigo) ? 'selected' : ''; ?>>
                        <?= $tipoPagamento->descricao; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="formaPagamento" class="block text-sm font-medium">Selecione uma forma de Pagamento:</label>
            <select id="formaPagamento" name="formaPagamento" required
                class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <?php foreach ($formasPagamento as $formaPagamento): ?>
                    <option value="<?= $formaPagamento->codigo; ?>" <?= (isset($saida) && $saida->id_forma_pagamento == $formaPagamento->codigo) ? 'selected' : ''; ?>>
                        <?= $formaPagamento->descricao; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="data_pagamento" class="block text-sm font-medium">Data Pagamento:</label>
            <input type="date" id="data_pagamento" name="data_pagamento"
                value="<?php echo (isset($saida) ? date('Y-m-d', strtotime($saida->data_pagamento)) : '') ?>"
                required class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="valor" class="block text-sm font-medium">Valor:</label>
            <input type="text" id="valor" name="valor"
                value="<?php echo (isset($saida) ? $saida->valor : '') ?>"
                class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="observacao" class="block text-sm font-medium">Descrição do pagamento:</label>
            <input type="text" id="observacao" name="observacao"
                value="<?php echo (isset($saida) ? $saida->observacao : '') ?>"
                class="w-full border border-gray-300 rounded px-4 py-2"
                placeholder="Ex: Portaria, roçagem, vendas">
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                <?php echo $acao; ?>
            </button>
        </div>
    </form>
</div>

<?php echo $this->include('footer'); ?>