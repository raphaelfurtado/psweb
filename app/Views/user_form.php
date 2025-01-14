<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<?php if (session()->getFlashdata('msg')): ?>
    <?php
    $msg = session()->getFlashdata('msg');
    $msgType = session()->getFlashdata('msg_type');
    $alertClass = $msgType === 'success' ? 'alert alert-success' : 'alert alert-danger';
    ?>
    <div class="alert <?= $alertClass ?>" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?= $msg ?>
    </div>

<?php endif; ?>

<div class="col-12 grid-margin stretch-card">

    <div class="card">

        <div class="card-body">
            <div class="template-demo">
                <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                    <i class="mdi mdi-keyboard-return"></i>
                    Voltar
                </a>
            </div>
            <br />
            <h1 class="card-title text-center"><?php echo $titulo ?></h1>
            <p class="card-description">
                Adicionar registro
            </p>
            <form method="post" class="forms-sample">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?php echo (isset($usuario) ? $usuario->nome : '') ?>"
                        class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="aniversario">Aniversário</label>
                    <input type="date" id="aniversario" name="aniversario"
                        value="<?php echo (isset($usuario) ? $usuario->aniversario : '') ?>"
                        class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone"
                        value="<?php echo (isset($usuario) ? $usuario->telefone : '') ?>"
                        class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="telefone_2">Telefone 2</label>
                    <input type="text" id="telefone_2" name="telefone_2"
                        value="<?php echo (isset($usuario) ? $usuario->telefone_2 : '') ?>"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" id="rua" name="rua" value="<?php echo (isset($endereco) ? $endereco->rua : '') ?>"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="quadra">Quadra</label>
                    <input type="text" id="quadra" name="quadra"
                        value="<?php echo (isset($endereco) ? $endereco->quadra : '') ?>"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="numero"
                        value="<?php echo (isset($endereco) ? $endereco->numero : '') ?>"
                        class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="qtd_lote">Qtd Lote</label>
                    <input type="number" id="qtd_lote" name="qtd_lote"
                        value="<?php echo (isset($endereco) ? $endereco->qtd_lote : '') ?>"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha"
                        class="form-control"
                        placeholder="Deixe em branco para não alterar a senha">
                    <span id="toggleSenha" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                        👁️
                    </span>
                </div>

                <button type="submit" class="btn btn-primary mr-2"><?php echo $acao; ?></button>
                <a href="<?php echo base_url($link) ?>" class="btn btn-light">
                    Cancelar
                </a>
            </form>

            <?php if ($acao != "Inserir"): ?>
                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4">Lista de Pagamentos de <?php echo $usuario->nome ?></h2>

                    <div class="table-responsive">
                        <?= $pagamentosTable ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>