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


<h5 class="mb-0 d-inline-block">Bem-vindo, <?php echo $nome; ?></h5>
<br /><br />

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body dashboard-tabs p-0">
                <ul class="nav nav-tabs" id="tab-unique-id-1">
                    <?php foreach ($informacoes as $index => $info): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>"
                                id="tab-<?php echo $info['codigo']; ?>" data-toggle="tab"
                                href="#content-<?php echo $info['codigo']; ?>" role="tab"
                                aria-controls="content-<?php echo $info['codigo']; ?>-1"
                                aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                                <?php echo $info['label']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Conteúdo das Abas -->
                <div class="tab-content py-0 px-0">
                    <?php foreach ($informacoes as $index => $info): ?>
                        <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>"
                            id="content-<?php echo $info['codigo']; ?>" role="tabpanel"
                            aria-labelledby="tab-<?php echo $info['codigo']; ?>-1">
                            <div class="d-flex flex-wrap justify-content-xl-between">
                                <?php foreach ($info['id_tipo_pagamento'] as $infoPag): ?>

                                    <!--  INICIO CARD MENSALIDADE -->
                                    <?php if ($infoPag['tipo'] === '3'): ?>
                                        <div
                                            class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                            <i class="mdi mdi-currency-usd mr-3 icon-lg text-success"></i>
                                            <div class="d-flex flex-column justify-content-around">
                                                <small class="mb-1 text-muted">Contribuição Portaria</small>
                                                <div class="d-flex">
                                                    <h5 class="mr-2 mb-0">
                                                        <?php echo $infoPag['total_quantidade_pago']; ?>
                                                        <small
                                                            class="mb-1 text-muted">/<?php echo $infoPag['total_quantidade_geral']; ?></small>
                                                        <p class="card-description">
                                                            faltam <?php echo $infoPag['total_quantidade_aberto']; ?>
                                                        </p>
                                                    </h5>
                                                    <h5 class="mb-0">
                                                        R$ <?php echo $infoPag['total_pago']; ?>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <!--  FIM CARD MENSALIDADE -->

                                    <!--  INICIO CARD TAXA DO 13° -->

                                    <?php if ($infoPag['tipo'] === '1'): ?>
                                        <div
                                            class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                            <i class="mdi mdi-currency-usd mr-3 icon-lg text-success"></i>
                                            <div class="d-flex flex-column justify-content-around">
                                                <small class="mb-1 text-muted">Contribuição 13° Salário Portaria</small>
                                                <div class="d-flex">
                                                    <h5 class="mr-2 mb-0">
                                                        <?php echo $infoPag['total_quantidade_pago']; ?>
                                                        <small class="mb-1 text-muted">/</small>
                                                    </h5>
                                                    <h5 class="mb-0">
                                                        R$ <?php echo $infoPag['total_pago']; ?>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!--  FIM CARD TAXA DO 13° -->

                                    <!--  INICIO CARD TAXA DO CONCRETO -->
                                    <?php if ($role === 'admin'): ?>
                                        <?php if ($infoPag['tipo'] === '4'): ?>
                                            <div
                                                class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                                <i class="mdi mdi-truck mr-3 icon-lg text-primary"></i>
                                                <div class="d-flex flex-column justify-content-around">
                                                    <small class="mb-1 text-muted">Contribuição Concreto</small>
                                                    <div class="d-flex">
                                                        <h5 class="mr-2 mb-0">
                                                            <?php echo $infoPag['total_quantidade_pago']; ?>
                                                            <small class="mb-1 text-muted">/</small>
                                                        </h5>
                                                        <h5 class="mb-0">
                                                            R$ <?php echo $infoPag['total_pago']; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!--  FIM CARD TAXA DO CONCRETO -->

                                    <!--  INICIO CARD TAXA ROÇAGEM -->
                                    <?php if ($role === 'admin'): ?>
                                        <?php if ($infoPag['tipo'] === '5'): ?>
                                            <div
                                                class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                                <i class="mdi mdi-pine-tree mr-3 icon-lg text-primary"></i>
                                                <div class="d-flex flex-column justify-content-around">
                                                    <small class="mb-1 text-muted">Contribuição Roçagem</small>
                                                    <div class="d-flex">
                                                        <h5 class="mr-2 mb-0">
                                                            <?php echo $infoPag['total_quantidade_pago']; ?>
                                                            <small class="mb-1 text-muted">/</small>
                                                        </h5>
                                                        <h5 class="mb-0">
                                                            R$ <?php echo $infoPag['total_pago']; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!--  FIM CARD TAXA ROÇAGEM -->


                                    <!--  INICIO CARD CONTRIBUIÇÕES AVULSAS -->
                                    <?php if ($role === 'admin'): ?>
                                        <?php if ($infoPag['tipo'] === '2'): ?>
                                            <div
                                                class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                                <i class="mdi mdi-briefcase mr-3 icon-lg text-info"></i>
                                                <div class="d-flex flex-column justify-content-around">
                                                    <small class="mb-1 text-muted">Contribuição Avulsa</small>
                                                    <div class="d-flex">
                                                        <h5 class="mr-2 mb-0">
                                                            <?php echo $infoPag['total_quantidade_pago']; ?>
                                                            <small class="mb-1 text-muted">/</small>
                                                        </h5>
                                                        <h5 class="mb-0">
                                                            R$ <?php echo $infoPag['total_pago']; ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!--  FIM CARD TAXA ROÇAGEM -->
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Repita o bloco acima com IDs e referências diferentes para outro conjunto de tabs -->
<?php echo $this->include('template/footer'); ?>