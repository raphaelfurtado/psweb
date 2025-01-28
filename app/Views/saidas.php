<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<?php if (session()->getFlashdata('msg_error')): ?>
    <div class="alert alert-danger" role="danger" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_error'); ?>.
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                        <i class="mdi mdi-plus btn-icon-prepend"></i>
                        Adicionar
                    </a>
                </div>
                <br />
                <h4 class="card-title"><?php echo $titulo ?></h4>
                <div class="table-responsive">
                    <table id="dataTableSaida" class="datatable table table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cód.</th>
                                <th>Data Pagamento</th>
                                <th>Referência</th>
                                <th>Tipo Saída</th>
                                <th>Descrição</th>
                                <th class="none"></th>
                                <th class="none"></th>
                                <th class="none"></th>
                                <th>Valor</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($saidas)): ?>
                                <?php foreach ($saidas as $saida): ?>
                                    <tr>
                                        <td><?php echo $saida->id ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($saida->data_pagamento)) ?></td>
                                        <td><?php echo $saida->referencia ?></td>
                                        <td><?php echo $saida->desc_pagamento ?></td>
                                        <td><?php echo $saida->observacao ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>R$ <?php echo number_format($saida->valor, 2, ',', '.') ?></td>
                                        <td>
                                            <button title="Editar Registro" type="button"
                                                class="btn btn-primary btn-rounded btn-icon"
                                                onclick="window.location.href='<?php echo base_url('/saida/editar/' . $saida->id) ?>'">
                                                <i class="mdi mdi-pen icon-sm"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4">Nenhum registro encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="8"></th>
                                <th>Total</th>
                                <th colspan="5"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>