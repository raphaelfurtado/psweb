<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2><?php echo $titulo ?></h2>

<strong><?php echo $msg ?></strong>

<div id="content">
    <form method="post">
        <p>
            <label for="descricao">Descrição do Pagamento:</label>
            <input type="text" id="descricao" name="descricao" required>
        </p>

        <p>
            <button type="submit">Inserir</button>
        </p>

    </form>
</div>

<?php echo  $this->include('footer'); ?>