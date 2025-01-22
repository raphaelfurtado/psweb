<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<?php if (session()->getFlashdata('msg')): ?>
    <?php
    $msg = session()->getFlashdata('msg');
    $msgType = session()->getFlashdata('msg_type');
    $alertClass = $msgType === 'success' ? 'alert alert-success' : 'alert alert-danger';
    ?>
    <div class="alert <?= $alertClass ?>" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?= $msg ?>
    </div>
    <br />
<?php endif; ?>

<?php if (session()->getFlashdata('msg_success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
        <strong>PSWEB informa:</strong> <?php echo session()->getFlashdata('msg_success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <br />
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
                    <table id="dataTablePagamentos" class="datatable table table-striped nowrap table-hover"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th class="desktop">OP</th>
                                <th class="desktop mobile tablet">Morador</th>
                                <th class="desktop mobile tablet">Quadra</th>
                                <th class="desktop mobile tablet">Nr da Casa</th>
                                <th class="desktop mobile tablet">Data Pagto</th>
                                <th class="desktop mobile tablet">Data Venc</th>
                                <th class="desktop mobile tablet">Ref.</th>
                                <th class="desktop tablet">Recebedor</th>
                                <th class="desktop mobile tablet">Valor</th>
                                <th class="desktop mobile tablet">Situação</th>
                                <th class="desktop mobile tablet">Forma</th>
                                <th class="desktop mobile tablet">Tipo</th>
                                <th class="none">Obs</th>
                                <th class="desktop mobile tablet"></th>
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

                                $dataVencimento = new DateTime($pagamento->data_vencimento);
                                $dataVencimento_formatada = $dataVencimento->format('Y-m-d');
                                $dataAtual = new DateTime("now");
                                $dataAtual_formatada = $dataAtual->format('Y-m-d');
                                $class = '';

                                if ($pagamento->situacao == 'ABERTO') {
                                    if ($dataVencimento_formatada < $dataAtual_formatada) {
                                        $class = 'text-danger font-weight-bold';
                                    } elseif ($dataVencimento_formatada > $dataAtual_formatada) {
                                        $class = '';
                                    } else {
                                        $class = 'text-warning font-weight-bold';
                                    }
                                }
                                ?>

                                <tr>
                                    <td><?php echo $pagamento->id_pagamento ?></td>
                                    <td><?php echo $pagamento->nome_morador ?></td>
                                    <td><?php echo $pagamento->quadra ?></td>
                                    <td><?php echo $pagamento->numero ?></td>
                                    <td><?php echo isset($pagamento->data_pagamento) ? date('d/m/Y', strtotime($pagamento->data_pagamento)) : '' ?>
                                    </td>
                                    <td><span class=<?= $class ?>><?php echo date('d/m/Y', strtotime($pagamento->data_vencimento)) ?></span></td>
                                    <td><?php echo $pagamento->referencia ?></td>
                                    <td><?php echo $pagamento->nome_recebedor ?></td>
                                    <td>R$ <?php echo number_format($pagamento->valor, 2, ',', '.') ?></td>
                                    <td><?php echo $situacaoClass ?></td>
                                    <td><?php echo $pagamento->desc_forma_pagto ?></td>
                                    <td><?php echo $pagamento->desc_pagamento ?></td>
                                    <td><?php echo $pagamento->observacao ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-rounded" type="button" id="actionMenu"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo base_url('/pagamento/editar/' . $pagamento->id_pagamento); ?>">
                                                        <i class="mdi mdi-pencil"></i> Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo base_url('/pagamento/excluir/' . $pagamento->id_pagamento); ?>"
                                                        onclick="return confirm('Tem certeza de que deseja excluir este pagamento?');">
                                                        <i class="mdi mdi-delete"></i> Excluir
                                                    </a>
                                                </li>
                                                <?php if ($pagamento->stored_name != ''): ?>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo base_url('/pagamento/downloadPagamento/' . $pagamento->stored_name); ?>"
                                                            target="_blank">
                                                            <i class="mdi mdi-eye"></i> Anexo
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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