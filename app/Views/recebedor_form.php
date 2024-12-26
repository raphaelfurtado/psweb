<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto p-4">

    <h2 class="text-2xl font-bold mb-4"><?php echo $titulo ?></h2>

    <?php if (!empty($msg)): ?>
        <strong class="block mb-4 text-green-600"><?php echo $msg ?></strong>
    <?php endif; ?>

    <p class="mb-4">
        <a href="<?php echo base_url($link) ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
    </p>

    <div id="content">
        <form method="post" class="space-y-4 bg-white p-6 rounded shadow">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nome" class="block font-medium">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo (isset($recebedor) ? $recebedor->nome : '') ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>

                <div>
                    <label for="aniversario">Data Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento"
                        value="<?php echo (isset($recebedor) ? $recebedor->data_nascimento : '') ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="telefone" class="block font-medium">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo (isset($recebedor) ? $recebedor->telefone : '') ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="telefone_2" class="block font-medium">Telefone 2:</label>
                    <input type="text" id="telefone_2" name="telefone_2" value="<?php echo (isset($recebedor) ? $recebedor->telefone_2 : '') ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>

            <div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                    <?php echo $acao ?>
                </button>
            </div>

        </form>
    </div>
</div>

<?php echo  $this->include('footer'); ?>