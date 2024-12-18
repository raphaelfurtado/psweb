<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2><?php echo $titulo ?></h2>

<div id="content">

    <p><a href="<?php echo base_url($link) ?>"><?php echo  $tituloRedirect ?> </a></p>

    <table class="tabela">
        <tr>
            <td>Cód. Pagto</td>
            <td>Morador</td>
            <td>Recebedor</td>
            <td>Número</td>
            <td>Quadra</td>
            <td>Data Pagamento</td>
            <td>Referência</td>
            <td>Valor</td>
            <td>Desc. Pagto</td>
            <td>Observação</td>
            <td>&nbsp;</td>
        </tr>
        <?php foreach ($pagamentos as $pagamento): ?>
            <tr>
                <td><?php echo $pagamento->id_pagamento ?></td>
                <td><?php echo $pagamento->nome_morador ?></td>
                <td><?php echo $pagamento->nome_recebedor ?></td>
                <td><?php echo $pagamento->numero ?></td>
                <td><?php echo $pagamento->quadra ?></td>
                <td><?php echo date('d/m/Y', strtotime($pagamento->data_pagamento)) ?></td>
                <td><?php echo $pagamento->referencia ?></td>
                <td><?php echo $pagamento->valor ?></td>
                <td><?php echo $pagamento->desc_pagamento ?></td>
                <td><?php echo $pagamento->observacao ?></td>
                <td><a href="<?php echo base_url('public/index.php/pagamento/editar/' . $pagamento->id_pagamento)?>">Editar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php echo $this->include('footer'); ?>