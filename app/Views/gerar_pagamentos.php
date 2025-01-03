<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto p-4">

    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div style="color: green;">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
            <?php echo $tituloRedirect ?>
        </a>
    </p>
    <br />
    <div id="content">
        <form method="post" class="space-y-4 bg-white p-6 rounded shadow">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="ano" class="block font-medium">Ano:</label>
                    <input type="number" id="ano" name="ano"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
            </div>

            <div class="flex justify-center sm:justify-start">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
                    Gerar Pagamentos
                </button>
            </div>
        </form>
    </div>
</div>


<?php echo $this->include('footer'); ?>