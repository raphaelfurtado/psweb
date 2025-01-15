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
                <h4 class="card-title">Tipos de Pagamento Cadastrados</h4>
                <div class="table-responsive">
                    <table id="dataTableSaida" class="table table-striped nowrap table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="desktop tablet mobile">Código</th>
                                <th class="desktop tablet mobile">Decrição</th>
                                <th class="desktop mobile tablet">Situação</th>
                                <th class="desktop tablet mobile"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                                <tr>
                                    <td><?php echo $tipoPagamento->codigo; ?></td>
                                    <td><?php echo $tipoPagamento->descricao; ?></td>
                                    <td>
                                        <?php if ($tipoPagamento->registro_ativo === '1'): ?>
                                            <label class="badge badge-success">ATIVO</label>
                                        <?php endif; ?>

                                        <?php if ($tipoPagamento->registro_ativo === '0'): ?>
                                            <label class="badge badge-danger">INATIVO</label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button title="Editar Registro" type="button"
                                            class="btn btn-primary btn-rounded btn-icon"
                                            onclick="window.location.href='<?php echo base_url('/tipoPagamento/editar/' . $tipoPagamento->id) ?>'">
                                            <i class="mdi mdi-pen icon-sm"></i>
                                        </button>

                                        <?php if ($tipoPagamento->registro_ativo === '1'): ?>
                                            <button title="Desativar Registro" type="button"
                                                class="btn btn-danger btn-rounded btn-icon"
                                                onclick="if (confirm('Tem certeza que deseja desativar o uso deste registro ?')) { window.location.href='<?php echo base_url('/tipoPagamento/desativar/' . $tipoPagamento->id); ?>'; }">
                                                <i class="mdi mdi-delete icon-sm"></i>
                                            </button>
                                        <?php endif; ?>

                                        <?php if ($tipoPagamento->registro_ativo === '0'): ?>
                                            <button title="Ativar Registro" type="button"
                                                class="btn btn-success btn-rounded btn-icon"
                                                onclick="if (confirm('Tem certeza que deseja ativar o uso deste registro ?')) { window.location.href='<?php echo base_url('/tipoPagamento/ativar/' . $tipoPagamento->id); ?>'; }">
                                                <i class="mdi mdi-check icon-sm"></i>
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