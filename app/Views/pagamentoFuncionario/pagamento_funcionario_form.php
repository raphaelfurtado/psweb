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

<div class="col-12 grid-margin stretch-card">

    <div class="card">

        <div class="card-body">
            <div class="template-demo">
                <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                    <i class="mdi mdi-keyboard-return"></i>
                    Voltar
                </a>
            </div>
            <br />
            <h1 class="card-title text-center"><?php echo $titulo ?></h1>
            <p class="card-description">
                Adicionar registro
            </p>
            <form method="post" class="forms-sample" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputName1">Selecione um Tipo de Saída: (de onde está saindo o valor)</label>
                    <select id="exampleInputName1" name="tipoPagamento" required class="form-control"
                        <?= isset($pagamento) ? 'disabled' : ''; ?>>
                        <option value="">-- Selecione --</option>
                        <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                            <option value="<?= $tipoPagamento->codigo; ?>" <?= (isset($saida) && $saida->id_tipo_pagamento == $tipoPagamento->codigo) ? 'selected' : ''; ?>>
                                <?= $tipoPagamento->descricao; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formaPagamento">Selecione uma forma de Pagamento:</label>
                    <select id="formaPagamento" name="formaPagamento" required class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($formasPagamento as $formaPagamento): ?>
                            <option value="<?= $formaPagamento->codigo; ?>" <?= (isset($saida) && $saida->id_forma_pagamento == $formaPagamento->codigo) ? 'selected' : ''; ?>>
                                <?= $formaPagamento->descricao; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipoSaida">Tipo saída:</label>
                    <select id="tipoSaida" name="tipoSaida" required class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($tiposSaida as $tipoSaida): ?>
                            <option value="<?= $tipoSaida->codigo; ?>" <?= (isset($saida) && $saida->id_tipo_saida == $tipoSaida->codigo) ? 'selected' : ''; ?>>
                                <?= $tipoSaida->descricao; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Data Pagamento</label>
                    <input type="date" id="data_pagamento" name="data_pagamento"
                        value="<?php echo (isset($saida) ? date('Y-m-d', strtotime($saida->data_pagamento)) : '') ?>"
                        required class="form-control">
                </div>
                <div class="form-group">
                    <label for="referencia">Referência</label>
                    <input type="text" id="referencia" name="referencia"
                        value="<?php echo (isset($saida) ? $saida->referencia : '') ?>"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" id="valor" name="valor"
                        value="<?php echo isset($saida) ? number_format($saida->valor, 2, ',', '.') : '' ?>"
                        class="form-control"
                        oninput="formatarMoeda(this)">
                </div>
                <div class="form-group">
                    <label for="observacao">Observação</label>
                    <textarea name="observacao" class="form-control"><?php echo isset($saida) ? htmlspecialchars($saida->observacao) : ''; ?></textarea>

                </div>
                <button type="submit" class="btn btn-primary mr-2"><?php echo $acao; ?></button>
                <a href="<?php echo base_url($link) ?>" class="btn btn-light">
                    Cancelar
                </a>
            </form>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>