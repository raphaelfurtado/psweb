<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div id="content">
    <p><a href="<?php echo base_url($link)?>"><?php echo  $tituloRedirect ?> </a></p>

    <table class="tabela">
        <tr>
            <td>Código</td>
            <td>Nome</td>
            <td>&nbsp;</td>
        </tr>
        <?php foreach ($moradores as $morador): ?>
            <tr>
                <td><?php echo $morador->id?></td>
                <td><?php echo $morador->nome?></td>
                <td><a href="<?php echo base_url('/user/editar/' . $morador->id)?>">Editar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php echo $this->include('footer'); ?>