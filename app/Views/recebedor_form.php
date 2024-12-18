<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<h2><?php echo $titulo ?></h2>

<strong><?php echo $msg ?></strong>

<div id="content">
    <form method="post">
        <p>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </p>

        <p>
            <label for="aniversario">Data Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
        </p>

        <p>
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" required>
        </p>

        <p>
            <label for="telefone">Telefone 2:</label>
            <input type="text" id="telefone_2" name="telefone_2">
        </p>

        <p>
            <button type="submit">Inserir</button>
        </p>

    </form>
</div>

<?php echo  $this->include('footer'); ?>