<?php echo $this->include('header'); ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Selecione o Relatório</h4>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card bg-primary text-white text-center p-3">
                            <a href="<?= base_url('relatorios/fluxo-caixa') ?>" class="text-white text-decoration-none">
                                <i class="mdi mdi-trending-up mdi-36px"></i>
                                <h5 class="mt-2">Fluxo de Caixa</h5>
                                <p class="small">Entradas e Saídas Consolidadas</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-danger text-white text-center p-3">
                            <a href="<?= base_url('relatorios/inadimplencia') ?>"
                                class="text-white text-decoration-none">
                                <i class="mdi mdi-account-alert mdi-36px"></i>
                                <h5 class="mt-2">Inadimplência</h5>
                                <p class="small">Moradores com pagamentos em atraso</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-success text-white text-center p-3">
                            <a href="<?= base_url('relatorios/folha-pagamento') ?>"
                                class="text-white text-decoration-none">
                                <i class="mdi mdi-worker mdi-36px"></i>
                                <h5 class="mt-2">Folha de Pagamento</h5>
                                <p class="small">Resumo de pagamentos a funcionários</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-info text-white text-center p-3">
                            <a href="<?= base_url('relatorios/prestacao-contas') ?>"
                                class="text-white text-decoration-none">
                                <i class="mdi mdi-clipboard-text mdi-36px"></i>
                                <h5 class="mt-2">Prestação de Contas</h5>
                                <p class="small">Detalhamento completo (Entradas e Saídas)</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-warning text-white text-center p-3">
                            <a href="<?= base_url('relatorios/receitas-categoria') ?>"
                                class="text-white text-decoration-none">
                                <i class="mdi mdi-format-list-bulleted-type mdi-36px"></i>
                                <h5 class="mt-2">Receitas por Categoria</h5>
                                <p class="small">Resumo agrupado por código</p>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-secondary text-white text-center p-3">
                            <a href="<?= base_url('relatorios/resumo-caixa') ?>"
                                class="text-white text-decoration-none">
                                <i class="mdi mdi-cash-multiple mdi-36px"></i>
                                <h5 class="mt-2">Resumo de Caixa</h5>
                                <p class="small">Consolidado por Tipo (E/S)</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>