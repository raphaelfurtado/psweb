<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2><?php echo $titulo ?></h2>

<strong><?php echo $msg ?></strong>

<div id="content">

    <p><a href="<?php echo base_url($link) ?>"><?php echo  $tituloRedirect ?> </a></p>

    <form method="post">
        <p>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo (isset($usuario) ? $usuario->nome : '') ?>" required>
        </p>

        <p>
            <label for="aniversario">Aniversário:</label>
            <input type="date" id="aniversario" name="aniversario" value="<?php echo (isset($usuario) ? $usuario->aniversario : '') ?>" required>
        </p>

        <p>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo (isset($usuario) ? $usuario->telefone : '') ?>" required>
        </p>

        <p>
            <label for="telefone">Telefone 2:</label>
            <input type="text" id="telefone_2" name="telefone_2" value="<?php echo (isset($usuario) ? $usuario->telefone_2 : '') ?>">
        </p>

        <p>
            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua" value="<?php echo (isset($usuario) ? $endereco->rua : '') ?>">
        </p>

        <p>
            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" value="<?php echo (isset($usuario) ? $endereco->numero : '') ?>" required>
        </p>

        <p>
            <label for="quadra">Quadra:</label>
            <input type="text" id="quadra" name="quadra" value="<?php echo (isset($usuario) ? $endereco->quadra : '') ?>">
        </p>

        <p>
            <button type="submit"><?php echo $acao?></button>
        </p>

    </form>
</div>

<?php echo  $this->include('footer'); ?>