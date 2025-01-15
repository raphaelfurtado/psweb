<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                        <i class="mdi mdi-keyboard-return btn-icon-prepend"></i>
                        Voltar
                    </a>
                </div>
                <br />
                <h4 class="card-title text-center"><?php echo $titulo ?></h4>
                <form class="forms-sample" action="<?= base_url($acao_form) ?>" method="POST">
                    <div class="form-group col-md-6">
                        <label for="codigo">Código:</label>
                        <input type="text" class="form-control" id="codigo" name="codigo"
                            value="<?php echo isset($tipo_pagamento) ? $tipo_pagamento->codigo : old('codigo') ?>"
                            <?php echo $tela === 'editar' ? 'readonly' : '' ?> />
                        <?php if (session('errors.codigo')): ?>
                            <div class="error"><?= session('errors.codigo') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="descricao">Descrição:</label>
                        <input type="text" class="form-control" id="descricao" name="descricao"
                            value="<?php echo isset($tipo_pagamento) ? $tipo_pagamento->descricao : old('descricao') ?>" />
                        <?php if (session('errors.descricao')): ?>
                            <div class="error"><?= session('errors.descricao') ?></div>
                        <?php endif; ?>
                    </div>
                
                    <button title="Editar Registro" 
                            type="submit"
                            class="btn btn-primary">
                        <?= $acao; ?>
                    </button>
                    <a href="<?php echo base_url($link) ?>" class="btn btn-light">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>