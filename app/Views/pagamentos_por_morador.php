<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="col-12 grid-margin stretch-card">

    <div class="card">

        <div class="card-body">
            <h1 class="card-title text-center"><?php echo $titulo ?></h1>
            <div class="mt-8">
                <div class="table-responsive">
                    <?= $pagamentosTable ?? '<p>Não há pagamentos disponíveis.</p>' ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>