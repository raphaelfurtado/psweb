<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div id="content">

    <p><a href="<?php echo base_url($link) ?>"><?php echo  $tituloRedirect ?> </a></p>

    <table class="tabela">
        <tr>
            <td>ID</td>
            <td>Código</td>
            <td>Descrição</td>
        </tr>
        <?php foreach ($tiposPagamento as $tipoPagamento): ?>
            <tr>
                <td><?php echo $tipoPagamento->id ?></td>
                <td><?php echo $tipoPagamento->codigo ?></td>
                <td><?php echo $tipoPagamento->descricao ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php echo $this->include('footer'); ?>