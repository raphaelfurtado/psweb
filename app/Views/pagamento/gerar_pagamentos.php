<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<?php if (session()->getFlashdata('msg_success')): ?>
    <div class="alert alert-success" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_success'); ?>.
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('msg_alert')): ?>
    <div class="alert alert-warning" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_error'); ?>.
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('msg_error')): ?>
    <div class="alert alert-danger" role="danger" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_error'); ?>.
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                        <i class="mdi mdi-keyboard-return btn-icon-prepend"></i>
                        Voltar para a lista de pagamentos
                    </a>
                </div>
                <br />
                <h4 class="card-title text-center"><?php echo $titulo ?></h4>
                <form class="forms-sample" method="POST" id="gerar-pagamentos-form">
                    <div class="form-group col-md-6">
                        <label for="ano">Ano:</label>
                        <input type="number" class="form-control" id="ano" name="ano" placeholder="Ex: 2025" />
                    </div>
                    <button id="gerar-pagamento-btn" title="Gerar" type="button" class="btn btn-primary">
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

<!-- Loading Spinner -->
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
    document.getElementById('gerar-pagamento-btn').addEventListener('click', function () {
        const ano = document.getElementById('ano').value;
        if (!ano) {
            alert('Por favor, insira um ano antes de continuar.');
            return;
        }

        const confirmacao = confirm(`Você tem certeza de que deseja gerar os pagamentos para o ano ${ano}?`);
        if (confirmacao) {
            // Mostra o spinner de loading
            document.getElementById('loading-spinner').style.display = 'block';

            // Submete o formulário
            document.getElementById('gerar-pagamentos-form').submit();
        }
    });
</script>

<?php echo $this->include('template/footer'); ?>