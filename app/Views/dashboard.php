<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2 class="text-lg font-semibold">Bem-vindo, <?php echo $nome; ?></h2>

<p>Você é um(a) <?php echo ucfirst($role); ?>.</p>

<?php echo $this->include('footer'); ?>