<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2>Bem-vindo(a), <?php echo $nome; ?></h2>

<p>Você é um(a) <?php echo ucfirst($role); ?>.</p>

<?php echo $this->include('footer'); ?>