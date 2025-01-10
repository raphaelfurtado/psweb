<?php echo $this->include('header', array('titulo' => $titulo)); ?>

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
                    <table id="dataTablePagamentos" class="datatable table table-striped nowrap table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="desktop">OP</th>
                                <th class="desktop mobile tablet">Morador</th>
                                <th class="desktop mobile tablet">Quadra</th>
                                <th class="desktop mobile tablet">Nr da Casa</th>
                                <th class="none">Data Pagto</th>
                                <th class="desktop mobile tablet">Ref.</th>
                                <th class="desktop tablet">Recebedor</th>
                                <th class="desktop mobile tablet">Valor</th>
                                <th class="desktop mobile tablet">Situação</th>
                                <th class="desktop mobile tablet">Tipo</th>
                                <th class="none">Obs</th>
                                <th class="desktop mobile tablet">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagamentos as $pagamento): ?>
                                <?php
                                $situacaoClass = '';
                                if ($pagamento->situacao === 'PAGO') {
                                    $situacaoClass = '<label class="badge badge-success">' . $pagamento->situacao . '</label>';
                                } elseif ($pagamento->situacao === 'PENDENTE') {
                                    $situacaoClass = '<label class="badge badge-warning">' . $pagamento->situacao . '</label>';
                                } elseif ($pagamento->situacao === 'CANCELADO') {
                                    $situacaoClass = '<label class="badge badge-danger">' . $pagamento->situacao . '</label>';
                                } elseif ($pagamento->situacao === 'ABERTO') {
                                    $situacaoClass = '<label class="badge badge-info">' . $pagamento->situacao . '</label>';
                                } else {
                                    $situacaoClass = '<label class="badge badge-warning">Indefinido</label>';
                                }
                                ?>

                                <tr>
                                    <td><?php echo $pagamento->id_pagamento ?></td>
                                    <td><?php echo $pagamento->nome_morador ?></td>
                                    <td><?php echo $pagamento->quadra ?></td>
                                    <td><?php echo $pagamento->numero ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($pagamento->data_pagamento)) ?></td>
                                    <td><?php echo $pagamento->referencia ?></td>
                                    <td><?php echo $pagamento->nome_recebedor ?></td>
                                    <td><?php echo number_format($pagamento->valor, 2, ',', '.') ?></td>
                                    <td><?php echo $situacaoClass ?></td>
                                    <td><?php echo $pagamento->desc_pagamento ?></td>
                                    <td><?php echo $pagamento->observacao ?></td>
                                    <td>
                                        <button title="Editar Registro" type="button"
                                            class="btn btn-primary btn-rounded btn-icon"
                                            onclick="window.location.href='<?php echo base_url('/pagamento/editar/' . $pagamento->id_pagamento) ?>'">
                                            <i class="mdi mdi-pen icon-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>