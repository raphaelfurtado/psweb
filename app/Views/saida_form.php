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
                <form class="forms-sample" method="POST">

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