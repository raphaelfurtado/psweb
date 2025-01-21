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
                                <th class="px-4 py-2 text-left">Cód.</th>
                                <th class="px-4 py-2 text-left">Nome</th>
                                <th class="px-4 py-2 text-left">Data Pagamento</th>
                                <th class="px-4 py-2 text-left">Valor</th>
                                <th class="px-4 py-2 text-left">Tipo Saída</th>
                                <th class="px-4 py-2 text-left">Descrição</th>
                                <th class="px-4 py-2 text-left">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($saidas as $saida): ?>
                                <tr class="border-t hover:bg-gray-100">
                                    <td class="px-4 py-2"><?php echo $saida->id ?></td>
                                    <td class="px-4 py-2"><?php echo $saida->nome_completo ?></td>
                                    <td class="px-4 py-2"><?php echo date('d/m/Y', strtotime($saida->data_pagamento)) ?></td>
                                    <td class="px-4 py-2">R$ <?php echo number_format($saida->valor, 2, ',', '.') ?></td>
                                    <td class="px-4 py-2"><?php echo $saida->desc_saida ?></td>
                                    <td class="px-4 py-2"><?php echo $saida->observacao ?></td>
                                    <td class="px-4 py-2">
                                        <a href="<?php echo base_url('pagamentoFuncionario/editar/' . $saida->id) ?>"
                                            class="text-blue-500 hover:underline">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th id="totalValor"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $this->include('template/footer'); ?>