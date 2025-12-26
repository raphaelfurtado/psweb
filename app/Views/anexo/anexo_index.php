<?php echo $this->include('header', array('titulo' => $titulo)); ?>

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
                    <table id="dataTableAnexos" class="table table-striped nowrap table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="desktop tablet mobile">OP.</th>
                                <th class="desktop tablet mobile">Morador</th>
                                <th class="desktop tablet mobile">Assunto</th>
                                <th class="desktop">Origem</th>
                                <th class="desktop">Formato</th>
                                <th class="desktop">Tipo</th>
                                <th class="desktop tablet mobile">Quadra</th>
                                <th class="desktop tablet mobile">Nr da Casa</th>
                                <th class="desktop">Inserção</th>
                                <th class="desktop"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($anexos as $anexo): ?>
                                <tr>
                                    <td><?php echo $anexo['identifier'] ?? $anexo['id_anexo']; ?></td>
                                    <td><?php echo $anexo['nome_morador']; ?></td>
                                    <td><?php echo $anexo['nome']; ?></td>
                                    <td><?php echo $anexo['form']; ?></td>
                                    <td><?php echo $anexo['tipo']; ?></td>
                                    <td><?php echo $anexo['tipo_anexo']; ?></td>
                                    <td><?php echo $anexo['quadra']; ?></td>
                                    <td><?php echo $anexo['numero']; ?></td>
                                    <td class="desktop"><?php echo $anexo['created_at']; ?></td>
                                    <td>
                                        <button title="Abrir Arquivo" type="button"
                                            class="btn btn-primary btn-rounded btn-icon"
                                            onclick="window.open('<?php echo base_url('anexo/download/' . $anexo['id_anexo']); ?>', '_blank');">
                                            <i class="mdi mdi-eye icon-sm"></i>
                                        </button>

                                        <?php if ($role === 'admin'): ?>
                                            <button title="Excluir do Arquivo" type="button"
                                                class="btn btn-danger btn-rounded btn-icon"
                                                onclick="if (confirm('Tem certeza que deseja deletar este anexo?')) { window.location.href='<?php echo base_url('anexo/deletar/' . $anexo['id_anexo']); ?>'; }">
                                                <i class="mdi mdi-delete icon-sm"></i>
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