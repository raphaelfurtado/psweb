<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div id="content">
    <h2><?php echo $titulo ?></h2>

    <p><a href="<?php echo base_url($link)?>"><?php echo  $tituloRedirect ?> </a></p>
    
    <table class="tabela">
        <tr>
            <td>Código</td>
            <td>Nome</td>
        </tr>
        <?php foreach ($recebedores as $recebedor): ?>
            <tr>
                <td><?php echo $recebedor->id ?></td>
                <td><?php echo $recebedor->nome ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php echo $this->include('footer'); ?>