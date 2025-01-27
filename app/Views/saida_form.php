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

<?php endif; ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-bold mb-4">Total de Pagamentos</h2>
                    <p class="text-green-700 font-semibold">
                        <strong>Total em caixa</strong>: R$ <?= number_format($totalPago - $totalSaida, 2, ',', '.') ?>
                    </p>
                    <p class="text-blue-700 font-semibold">
                        Total de saídas: R$ <?= number_format($totalSaida, 2, ',', '.') ?>
                    </p>
                </div>

                <div class="template-demo">
                    <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                        <i class="mdi mdi-keyboard-return btn-icon-prepend"></i>
                        Voltar
                    </a>
                </div>
                <br />
                <h4 class="card-title text-center"><?php echo $titulo ?></h4>
                <form class="forms-sample" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="tipoPagamento">Selecione um Tipo de Saída: (de onde está saindo o valor)</label>
                        <select class="form-control" id="tipoPagamento" name="tipoPagamento" required>
                            <option value="">-- Selecione --</option>
                            <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                                <option value="<?= $tipoPagamento->codigo; ?>" <?= (isset($saida) && $saida->id_tipo_pagamento == $tipoPagamento->codigo) ? 'selected' : ''; ?>>
                                    <?= $tipoPagamento->descricao; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="formaPagamento">Selecione uma forma de Pagamento</label>
                        <select class="form-control" id="formaPagamento" name="formaPagamento" required>
                            <option value="">-- Selecione --</option>
                            <?php foreach ($formasPagamento as $formaPagamento): ?>
                                <option value="<?= $formaPagamento->codigo; ?>" <?= (isset($saida) && $saida->id_forma_pagamento == $formaPagamento->codigo) ? 'selected' : ''; ?>>
                                    <?= $formaPagamento->descricao; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Data Pagamento</label>
                        <input class="form-control" type="date" id="data_pagamento" name="data_pagamento"
                            value="<?php echo (isset($saida) ? date('Y-m-d', strtotime($saida->data_pagamento)) : '') ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input class="form-control" type="text" id="valor" name="valor"
                            value="<?php echo isset($saida) ? number_format($saida->valor, 2, ',', '.') : '' ?>"
                            oninput="formatarMoeda(this)">
                    </div>

                    <div class="form-group">
                        <label for="files">Arquivo:</label>

                        <?php if (!empty($anexo)): ?>
                            <!-- Exibir informações do anexo atual -->
                            <p>
                                <a href="<?php echo base_url('/pagamento/downloadPagamento/' . $anexo['stored_name']); ?>" target="_blank">
                                    <i class="mdi mdi-eye"></i> <?php echo $anexo['original_name']; ?>
                                </a>
                            </p>
                            <!-- Botão para excluir o anexo -->
                            <div class="form-check">
                                <input type="checkbox" id="delete_anexo" name="delete_anexo" class="form-check-input">
                                <label for="delete_anexo" class="form-check-label">Excluir Anexo</label>
                            </div>
                        <?php endif; ?>

                        <!-- Campo para upload de novo anexo -->
                        <input type="file" id="file" name="file" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">
                                    <i class="mdi mdi-folder-upload"></i>
                                </button>
                            </span>
                            <input type="text" class="form-control file-upload-info" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Título:</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Título do arquivo"
                            value="<?php echo (isset($anexo) ? $anexo['subject'] : '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="observacao">Descrição do pagamento</label>
                        <input class="form-control" type="text" id="observacao" name="observacao"
                            value="<?php echo (isset($saida) ? $saida->observacao : '') ?>"
                            placeholder="Ex: Portaria, roçagem, vendas">
                    </div>

                    <button type="submit" class="btn btn-primary mr-2"> <?= $acao; ?></button>
                    <a href="<?php echo base_url($link) ?>" class="btn btn-light">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>