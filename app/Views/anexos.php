<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="container mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-4 text-center sm:text-left"><?php echo $titulo ?></h2>

    <?php if ($role === 'admin'): ?>
        <p class="mb-4 text-center sm:text-left">
            <a href="<?php echo base_url($link) ?>" class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700">
                <?php echo $tituloRedirect ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg_success')): ?>
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-4" id="flash-message">
            <strong>PSWEB Informa: </strong><?php echo session()->getFlashdata('msg_success'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg_error')): ?>
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md mb-4" id="flash-message">
            <strong>PSWEB Informa: </strong><?php echo session()->getFlashdata('msg_error'); ?>
        </div>
    <?php endif; ?>

    <script>
        setTimeout(function () {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 3000);
    </script>

    <div class="overflow-x-auto">
        <table class="table-auto w-full bg-white shadow-md rounded text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Formato</th>
                    <th class="px-4 py-2 text-left">Tipo</th>
                    <th class="px-4 py-2 text-left">Assunto</th>
                    <th class="px-4 py-2 text-left">Morador</th>
                    <th class="px-4 py-2 text-left">Quadra</th>
                    <th class="px-4 py-2 text-left">Nr da Casa</th>
                    <th class="px-4 py-2 text-left">Data Inserção</th>
                    <th class="px-4 py-2 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($anexos as $anexo): ?>
                    <tr class="border-t hover:bg-gray-100">
                        <td class="px-4 py-2"><?php echo $anexo['tipo']; ?></td>
                        <td class="px-4 py-2"><?php echo $anexo['tipo_anexo']; ?></td>
                        <td class="px-4 py-2"><?php echo $anexo['nome']; ?></td>
                        <td class="px-4 py-2"><?php echo $anexo['nome_morador']; ?></td>
                        <td class="px-4 py-2"><?php echo $anexo['quadra']; ?></td>
                        <td class="px-4 py-2"><?php echo $anexo['numero']; ?></td>
                        <td class="px-4 py-2"><?php echo $anexo['created_at']; ?></td>
                        <td class="py-2 px-4 border-b text-center flex space-x-2 justify-center">
                            <!-- Botão para download -->
                            <a href="<?php echo base_url('anexo/download/' . $anexo['stored_name']); ?>"
                                class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-700" title="Download">
                                <i class="fas fa-download"></i>
                            </a>

                            <?php if ($role === 'admin'): ?>
                                <!-- Botão para deletar -->
                                <a href="<?php echo base_url('anexo/deletar/' . $anexo['id_anexo']); ?>"
                                    class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-700"
                                    onclick="return confirm('Tem certeza que deseja deletar este anexo?')" title="Deletar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo $this->include('footer'); ?>