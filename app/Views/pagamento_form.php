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
    <form method="post" class="space-y-4">
        <div>
            <label for="morador" class="block text-sm font-medium">Selecione um morador:</label>
            <select id="morador" name="morador" required class="w-full border border-gray-300 rounded px-4 py-2"
                <?= isset($pagamento) ? 'disabled' : ''; ?>>
                <option value="">-- Selecione --</option>
                <?php foreach ($moradores as $morador): ?>
                    <option value="<?= $morador->id; ?>" <?= (isset($pagamento) && $pagamento->id_usuario == $morador->id) ? 'selected' : ''; ?>>
                        <?= $morador->nome; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="recebedor" class="block text-sm font-medium">Selecione um Recebedor:</label>
            <select id="recebedor" name="recebedor" required class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <?php foreach ($recebedores as $recebedor): ?>
                    <option value="<?= $recebedor->id; ?>" <?= (isset($pagamento) && $pagamento->id_recebedor == $recebedor->id) ? 'selected' : ''; ?>>
                        <?= $recebedor->nome; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="tipoPagamento" class="block text-sm font-medium">Selecione um Tipo de Pagamento:</label>
            <select id="tipoPagamento" name="tipoPagamento" required
                class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                    <option value="<?= $tipoPagamento->codigo; ?>" <?= (isset($pagamento) && $pagamento->id_tipo_pagamento == $tipoPagamento->codigo) ? 'selected' : ''; ?>>
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
                    <option value="<?= $formaPagamento->codigo; ?>" <?= (isset($pagamento) && $pagamento->id_forma_pagamento == $formaPagamento->codigo) ? 'selected' : ''; ?>>
                        <?= $formaPagamento->descricao; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="data_pagamento" class="block text-sm font-medium">Data Pagamento:</label>
            <input type="date" id="data_pagamento" name="data_pagamento"
                value="<?php echo (isset($pagamento) ? date('Y-m-d', strtotime($pagamento->data_pagamento)) : '') ?>"
                required class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="referencia" class="block text-sm font-medium">Referência:</label>
            <input type="text" id="referencia" name="referencia"
                value="<?php echo (isset($pagamento) ? $pagamento->referencia : '') ?>" required
                class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="valor" class="block text-sm font-medium">Valor:</label>
            <input type="text" id="valor" name="valor"
                value="<?php echo (isset($pagamento) ? $pagamento->valor : '') ?>"
                class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="situacao" class="block text-sm font-medium">Situação:</label>
            <select id="situacao" name="situacao" required class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <?php foreach ($situacoes as $situacao): ?>
                    <option value="<?= $situacao; ?>" <?= (isset($pagamento) && $pagamento->situacao == $situacao) ? 'selected' : ''; ?>>
                        <?= ucfirst($situacao); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="observacao" class="block text-sm font-medium">Observação:</label>
            <input type="text" id="observacao" name="observacao"
                value="<?php echo (isset($pagamento) ? $pagamento->observacao : '') ?>"
                class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                <?php echo $acao; ?>
            </button>
        </div>
    </form>
</div>

<?php echo $this->include('footer'); ?>