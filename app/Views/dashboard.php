<?php echo $this->include('template/header', array('titulo' => $titulo)); ?>

<?php echo $this->include('template/topbar'); ?>

<?php echo $this->include('template/sidebar'); ?>

<h2 class="text-lg font-semibold">Bem-vindo, <?php echo $nome; ?></h2>

<p>Você é um(a) <?php echo ucfirst($role); ?>.</p>

<?php echo $this->include('template/footer'); ?>