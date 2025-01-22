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
                <h4 class="card-title">Tipos de Saída Cadastradas</h4>
                <div class="table-responsive">
                    <table id="dataTablePagamentosFuncionario" class="table table-striped nowrap table-hover" style="width:100%">
                        <thead>
                            <tr class="bg-gray-200">
                                <th>Cód.</th>
                                <th>Nome</th>
                                <th>Referência</th>
                                <th>Data Pagamento</th>
                                <th>Valor</th>
                                <th>Tipo Saída</th>
                                <th>Descrição</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($saidas as $saida): ?>
                                <tr class="border-t hover:bg-gray-100">
                                    <td><?php echo $saida->id ?></td>
                                    <td><?php echo $saida->nome_completo ?></td>
                                    <td><?php echo $saida->referencia ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($saida->data_pagamento)) ?></td>
                                    <td>R$ <?php echo number_format($saida->valor, 2, ',', '.') ?></td>
                                    <td><?php echo $saida->desc_saida ?></td>
                                    <td><?php echo $saida->observacao ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-rounded" type="button" id="actionMenu"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo base_url('pagamentoFuncionario/editar/' . $saida->id) ?>">
                                                        <i class="mdi mdi-pencil"></i> Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo base_url('/pagamentoFuncionario/excluir/' . $saida->id); ?>"
                                                        onclick="return confirm('Tem certeza de que deseja excluir este pagamento?');">
                                                        <i class="mdi mdi-delete"></i> Excluir
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th id="totalValor"></th>
                                <th colspan="6"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $this->include('template/footer'); ?>