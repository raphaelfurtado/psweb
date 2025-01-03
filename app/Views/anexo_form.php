<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

<strong class="text-lg text-red-500 mb-4 block text-center sm:text-left"><?php echo $msg ?></strong>

<div id="upload-url" data-url="<?= base_url('/anexo/upload') ?>"></div>

<div id="content" class="max-w-4xl mx-auto p-4">

    <p class="mb-4 text-center sm:text-left">
        <a href="<?php echo base_url($link) ?>"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 block sm:inline-block text-center">
            <?php echo $tituloRedirect ?>
        </a>
    </p>
    <br />

    <form class="space-y-4" id="upload-form" action="<?= base_url('/anexo/upload') ?>" method="POST"
        enctype="multipart/form-data">
        <div>
            <label for="tipo_anexo" class="block text-sm font-medium">Selecione o Tipo de Anexo:</label>
            <select id="tipo_anexo" name="type_anex" required class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <option value="1">Associação</option>
                <option value="2">Morador</option>
            </select>
        </div>

        <div>
            <label for="morador" class="block text-sm font-medium">Selecione um morador:</label>
            <select id="morador" name="id_morador" required class="w-full border border-gray-300 rounded px-4 py-2">
                <option value="">-- Selecione --</option>
                <?php foreach ($moradores as $morador): ?>
                    <option value="<?= $morador->id; ?>">
                        <?= $morador->nome; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium">Titulo:</label>
            <input type="text" id="subject" name="subject" value='' required
                class="w-full border border-gray-300 rounded px-4 py-2">
        </div>

        <div>
            <label for="files" class="block text-sm font-medium">Arquivos:</label>
            <input type="file" id="files" name="files[]" multiple
                class="w-full border border-gray-300 rounded px-4 py-2">
            <div id="file-list" class="mt-2 mb-2"></div>
        </div>

        <div>
            <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">
                <?= $acao; ?>
            </button>
        </div>
    </form>
</div>

<?php echo $this->include('footer'); ?>