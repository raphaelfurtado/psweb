<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2><?php echo $titulo ?></h2>

<strong><?php echo $msg ?></strong>

<div id="content">

    <p><a href="<?php echo base_url($link) ?>"><?php echo  $tituloRedirect ?> </a></p>

    <form method="post">
        <p>
            <label for="morador">Selecione um morador:</label>
            <select id="morador" name="morador" required <?= isset($pagamento) ? 'disabled' : ''; ?>>
                <option value="">-- Selecione --</option>
                <?php foreach ($moradores as $morador): ?>
                    <option value="<?= $morador->id; ?>"
                        <?= (isset($pagamento) && $pagamento->id_usuario == $morador->id) ? 'selected' : ''; ?>>
                        <?= $morador->nome; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="recebedor">Selecione um Recebedor:</label>
            <select id="recebedor" name="recebedor" required>
                <option value="">-- Selecione --</option>
                <?php foreach ($recebedores as $recebedor): ?>
                    <option value="<?= $recebedor->id; ?>"
                        <?= (isset($pagamento) && $pagamento->id_recebedor == $recebedor->id) ? 'selected' : ''; ?>>
                        <?= $recebedor->nome; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="tipoPagamento">Selecione um Tipo de Pagamento:</label>
            <select id="tipoPagamento" name="tipoPagamento" required>
                <option value="">-- Selecione --</option>
                <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                    <option value="<?= $tipoPagamento->id; ?>"
                        <?= (isset($pagamento) && $pagamento->id_tipo_pagamento == $tipoPagamento->id) ? 'selected' : ''; ?>
                    >
                        <?= $tipoPagamento->descricao; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label for="data_pagamento">Data Pagamento:</label>
            <input type="date" id="data_pagamento" name="data_pagamento" value="<?php echo (isset($pagamento) ? date('Y-m-d', strtotime($pagamento->data_pagamento)) : '') ?>" required>
        </p>

        <p>
            <label for="referencia">Referência:</label>
            <input type="text" id="referencia" name="referencia" value="<?php echo (isset($pagamento) ? $pagamento->referencia : '') ?>" required>
        </p>

        <p>
            <label for="valor">Valor:</label>
            <input type="text" id="valor" name="valor" value="<?php echo (isset($pagamento) ? $pagamento->valor : '') ?>">
        </p>

        <p>
            <label for="observacao">Observacao:</label>
            <input type="text" id="observacao" name="observacao" value="<?php echo (isset($pagamento) ? $pagamento->observacao : '') ?>">
        </p>

        <p>
            <button type="submit"><?php echo $acao; ?></button>
        </p>

    </form>
</div>

<?php echo  $this->include('footer'); ?>