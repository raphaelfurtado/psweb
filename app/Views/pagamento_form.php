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
                    <label for="exampleInputName1">Selecione um morador</label>
                    <select id="exampleInputName1" name="morador" required class="form-control"
                        <?= isset($pagamento) ? 'disabled' : ''; ?>>
                        <option value="">-- Selecione --</option>
                        <?php foreach ($moradores as $morador): ?>
                            <option value="<?= $morador->id; ?>" <?= (isset($pagamento) && $pagamento->id_usuario == $morador->id) ? 'selected' : ''; ?>>
                                <?= $morador->nome; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recebedor">Selecione um Recebedor</label>
                    <select id="recebedor" name="recebedor" required class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($recebedores as $recebedor): ?>
                            <option value="<?= $recebedor->id; ?>" <?= (isset($pagamento) && $pagamento->id_recebedor == $recebedor->id) ? 'selected' : ''; ?>>
                                <?= $recebedor->nome; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipoPagamento">Selecione um Tipo de Pagamento</label>
                    <select id="tipoPagamento" name="tipoPagamento" required
                        class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($tiposPagamento as $tipoPagamento): ?>
                            <option value="<?= $tipoPagamento->codigo; ?>" <?= (isset($pagamento) && $pagamento->id_tipo_pagamento == $tipoPagamento->codigo) ? 'selected' : ''; ?>>
                                <?= $tipoPagamento->descricao; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formaPagamento">Selecione uma forma de Pagamento</label>
                    <select id="formaPagamento" name="formaPagamento" required
                        class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($formasPagamento as $formaPagamento): ?>
                            <option value="<?= $formaPagamento->codigo; ?>" <?= (isset($pagamento) && $pagamento->id_forma_pagamento == $formaPagamento->codigo) ? 'selected' : ''; ?>>
                                <?= $formaPagamento->descricao; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Data Pagamento</label>
                    <input type="date" id="data_pagamento" name="data_pagamento"
                        value="<?php echo (isset($pagamento) ? date('Y-m-d', strtotime($pagamento->data_pagamento)) : '') ?>"
                        required class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Data Vencimento</label>
                    <input type="date" id="data_vencimento" name="data_vencimento"
                        value="<?php echo (isset($pagamento) ? date('Y-m-d', strtotime($pagamento->data_vencimento)) : '') ?>"
                        required class="form-control">
                </div>
                <div class="form-group">
                    <label for="referencia">Referência</label>
                    <input type="text" id="referencia" name="referencia"
                        value="<?php echo (isset($pagamento) ? $pagamento->referencia : '') ?>" required
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label>
                    <input type="text" id="valor" name="valor"
                        value="<?php echo isset($pagamento) ? number_format($pagamento->valor, 2, ',', '.') : '' ?>"
                        oninput="formatarMoeda(this)"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="situacao">Situação</label>
                    <select id="situacao" name="situacao" required class="form-control">
                        <option value="">-- Selecione --</option>
                        <?php foreach ($situacoes as $situacao): ?>
                            <option value="<?= $situacao; ?>" <?= (isset($pagamento) && $pagamento->situacao == $situacao) ? 'selected' : ''; ?>>
                                <?= ucfirst($situacao); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
                    <input type="file" id="files" name="files" class="file-upload-default">
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
                    <label for="observacao">Observação</label>
                    <textarea name="observacao" class="form-control"><?php echo isset($pagamento) ? htmlspecialchars($pagamento->observacao) : ''; ?></textarea>

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