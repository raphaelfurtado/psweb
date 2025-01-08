<?php echo $this->include('template/header', array('titulo' => $titulo)); ?>

<?php echo $this->include('template/topbar'); ?>

<?php echo $this->include('template/sidebar', array('role' => $role)); ?>

<?php if (session()->getFlashdata('msg_success')): ?>
    <div class="alert alert-success" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_success'); ?>.
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('msg_error')): ?>
    <div class="alert alert-warning" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_error'); ?>.
    </div>
<?php endif; ?>

<script>
    function fadeOut(element, duration) {
        let opacity = 1;  // Começar com opacidade total
        const interval = 50; // Intervalo para diminuir a opacidade
        const gap = interval / duration;  // O valor que vai ser subtraído da opacidade
        // Função de animação
        const fade = setInterval(function () {
            opacity -= gap;
            if (opacity <= 0) {
                clearInterval(fade); // Parar a animação quando a opacidade atingir 0
                element.style.display = 'none'; // Esconder o elemento
            } else {
                element.style.opacity = opacity; // Atualiza a opacidade do elemento
            }
        }, interval);
    }
    // Aplicar o fadeOut nas mensagens 
    setTimeout(function () {
        const successMessage = document.getElementById('flash-message');
        if (successMessage) {
            fadeOut(successMessage, 1000); // 1 segundo de fade
        }
    }, 2000); // Atraso de 3 segundos antes de iniciar o fade
</script>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if ($role === 'admin'): ?>
                    <div class="template-demo">
                        <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                            <i class="mdi mdi-plus btn-icon-prepend"></i>
                            Adicionar
                        </a>
                    </div>
                <?php endif; ?>
                <br />
                <h4 class="card-title">Documentos Cadastrados</h4>
                <div class="table-responsive">
                    <table id="example" class="table table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Morador</th>
                                <th>Assunto</th>
                                <th>Formato</th>
                                <th>Tipo</th>
                                <th>Quadra</th>
                                <th>Nr da Casa</th>
                                <th>Data Inserção</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($anexos as $anexo): ?>
                                <tr>
                                    <td><?php echo $anexo['nome_morador']; ?></td>
                                    <td><?php echo $anexo['nome']; ?></td>
                                    <td><?php echo $anexo['tipo']; ?></td>
                                    <td><?php echo $anexo['tipo_anexo']; ?></td>
                                    <td><?php echo $anexo['quadra']; ?></td>
                                    <td><?php echo $anexo['numero']; ?></td>
                                    <td><?php echo $anexo['created_at']; ?></td>
                                    <td>
                                        <!-- Botão para download -->
                                        <button type="button" class="btn btn-primary btn-rounded btn-icon"
                                            onclick="window.location.href='<?php echo base_url('anexo/download/' . $anexo['stored_name']); ?>'">
                                            <i class="mdi mdi-home"></i>
                                        </button>

                                        <?php if ($role === 'admin'): ?>
                                            <!-- Botão para deletar -->
                                            <button type="button" class="btn btn-danger btn-rounded btn-icon"
                                                onclick="if (confirm('Tem certeza que deseja deletar este anexo?')) { window.location.href='<?php echo base_url('anexo/deletar/' . $anexo['id_anexo']); ?>'; }">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>