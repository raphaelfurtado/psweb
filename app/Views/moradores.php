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
                    <?php if (!empty($pagamentosNaoCadastrados)): ?>
                        <button class="btn btn-warning text-black" data-toggle="modal" data-target="#gerarPagamentosModal">
                            <i class="mdi mdi-deskphone btn-icon-prepend"></i>
                            Gerar Pagamentos
                        </button>
                    <?php endif; ?>

                    <?php if (empty($pagamentosNaoCadastrados)): ?>
                        <label class="mr-2" style="font-size: 1rem;">
                            <i class="text-danger mdi mdi-alert-circle"></i>
                            Todos os moradores possuem pagamentos no ano corrente.
                        </label>
                    <?php endif; ?>
                </div>
                <br />
                <h4 class="card-title"><?php echo $titulo ?></h4>
                <div class="table-responsive">
                    <table id="dataTableMoradores" class="datatable table table-striped nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <!-- <th class="px-4 py-2">Código</th> -->
                                <th class="desktop mobile tablet">Nome</th>
                                <th class="desktop mobile tablet">Telefone</th>
                                <th class="desktop mobile tablet">Telefone 2</th>
                                <th class="desktop mobile tablet">Quadra</th>
                                <th class="desktop mobile tablet">Número</th>
                                <th class="desktop mobile tablet"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($moradores)): ?>
                                <?php foreach ($moradores as $morador): ?>
                                    <tr>
                                        <!-- <td class="px-4 py-2"><?php //echo $morador->id 
                                                ?></td> -->
                                        <td><?php echo $morador->nome ?></td>
                                        <td><?php echo $morador->telefone ?? 'Não informado'; ?></td>
                                        <td><?php echo $morador->telefone_2 ?? 'Não informado'; ?></td>
                                        <td><?php echo $morador->quadra ?? 'Não informado'; ?></td>
                                        <td><?php echo $morador->numero ?? 'Não informado'; ?></td>
                                        <td>
                                            <button title="Editar Registro" type="button"
                                                class="btn btn-primary btn-rounded btn-icon"
                                                onclick="window.location.href='<?php echo base_url('/user/editar/' . $morador->id_user) ?>'">
                                                <i class="mdi mdi-pen icon-sm"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4">Nenhum morador encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5"></th>
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

<!-- Modal Gerar Pagamentos -->
<div class="modal fade" id="gerarPagamentosModal" tabindex="-1" role="dialog"
    aria-labelledby="gerarPagamentosModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="gerarPagamentosModalLabel">Moradores sem pagamento para o ano
                    <?php echo date('Y'); ?>
                </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="gera-pagamento-morador" action="<?= base_url('/user/gerarPagamentosMorador') ?>"
                    method="POST">
                    <ul class="list-ticked" id="moradoresList">
                        <?php if (!empty($pagamentosNaoCadastrados)): ?>
                            <?php foreach ($pagamentosNaoCadastrados as $morador): ?>
                                <li><?php echo $morador->nome; ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Não há moradores sem pagamentos no ano corrente.</p>
                        <?php endif; ?>
                    </ul>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button id="gerar-pagamento-morador-btn" type="submit" class="btn btn-primary">Gerar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="loading-spinner"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.8); z-index: 9999; text-align: center;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p>Aguarde, estamos processando...</p>
    </div>
</div>


<script>
    document.getElementById('gerar-pagamento-morador-btn').addEventListener('click', function () {
        // Mostrar o overlay de loading
        const loadingOverlay = document.getElementById('loading-spinner');
        loadingOverlay.style.display = 'flex';
    });
</script>

<?php echo $this->include('template/footer'); ?>