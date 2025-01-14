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
                    <input type="text" id="nome" name="nome"
                        value="<?php echo (isset($usuario) ? $usuario->nome : '') ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="aniversario">Aniversário</label>
                    <input type="date" id="aniversario" name="aniversario"
                        value="<?php echo (isset($usuario) ? $usuario->aniversario : '') ?>" class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone"
                        value="<?php echo (isset($usuario) ? $usuario->telefone : '') ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="telefone_2">Telefone 2</label>
                    <input type="text" id="telefone_2" name="telefone_2"
                        value="<?php echo (isset($usuario) ? $usuario->telefone_2 : '') ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" id="rua" name="rua"
                        value="<?php echo (isset($endereco) ? $endereco->rua : '') ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quadra">Quadra</label>
                    <input type="text" id="quadra" name="quadra"
                        value="<?php echo (isset($endereco) ? $endereco->quadra : '') ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="numero"
                        value="<?php echo (isset($endereco) ? $endereco->numero : '') ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="qtd_lote">Qtd Lote</label>
                    <input type="number" id="qtd_lote" name="qtd_lote"
                        value="<?php echo (isset($endereco) ? $endereco->qtd_lote : '') ?>" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Possui Acordo de Pagamento de Taxa de Portaria?</label>
                            <div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="possui_acordo"
                                            id="acordoRadios2" value="NAO" <?php echo !isset($usuario) || is_null($usuario->possui_acordo) || $usuario->possui_acordo === 'NAO' ? 'checked' : ''; ?>>
                                        Não
                                    </label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="possui_acordo"
                                            id="acordoRadios1" value="SIM" <?php echo isset($usuario) && $usuario->possui_acordo === 'SIM' ? 'checked' : ''; ?>>
                                        Sim
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="acordo">Acordo</label>
                            <textarea class="form-control" id="acordo" name="acordo"
                                rows="4"><?php echo isset($usuario) ? $usuario->acordo : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control"
                        placeholder="Deixe em branco para não alterar a senha">
                    <!-- <span id="toggleSenha"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer text-gray-500">
                         👁️ 
                    </span> -->
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
                        <table id="dataTablePagamentos" class="datatable table table-striped nowrap table-hover"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="desktop">OP</th>
                                    <th class="desktop mobile tablet">Morador</th>
                                    <th class="desktop mobile tablet">Quadra</th>
                                    <th class="desktop mobile tablet">Nr da Casa</th>
                                    <th class="desktop mobile tablet">Data Pagto</th>
                                    <th class="none">Data Venc</th>
                                    <th class="desktop mobile tablet">Ref.</th>
                                    <th class="desktop tablet">Recebedor</th>
                                    <th class="desktop mobile tablet">Valor</th>
                                    <th class="desktop mobile tablet">Situação</th>
                                    <th class="desktop mobile tablet">Forma</th>
                                    <th class="desktop mobile tablet">Tipo</th>
                                    <th class="none">Obs</th>
                                    <th class="desktop mobile tablet">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagamentos as $pagamento): ?>
                                    <?php
                                    $situacaoClass = '';
                                    if ($pagamento->situacao === 'PAGO') {
                                        $situacaoClass = '<label class="badge badge-success">' . $pagamento->situacao . '</label>';
                                    } elseif ($pagamento->situacao === 'PENDENTE') {
                                        $situacaoClass = '<label class="badge badge-warning">' . $pagamento->situacao . '</label>';
                                    } elseif ($pagamento->situacao === 'CANCELADO') {
                                        $situacaoClass = '<label class="badge badge-danger">' . $pagamento->situacao . '</label>';
                                    } elseif ($pagamento->situacao === 'ABERTO') {
                                        $situacaoClass = '<label class="badge badge-info">' . $pagamento->situacao . '</label>';
                                    } else {
                                        $situacaoClass = '<label class="badge badge-warning">Indefinido</label>';
                                    }

                                    $dataVencimento = new DateTime($pagamento->data_vencimento);
                                    $dataVencimento_formatada = $dataVencimento->format('Y-m-d');
                                    $dataAtual = new DateTime("now");
                                    $dataAtual_formatada = $dataAtual->format('Y-m-d');
                                    $class = '';

                                    if ($pagamento->situacao == 'ABERTO') {
                                        if ($dataVencimento_formatada < $dataAtual_formatada) {
                                            $class = 'text-danger font-weight-bold';
                                        } elseif ($dataVencimento_formatada > $dataAtual_formatada) {
                                            $class = '';
                                        } else {
                                            $class = 'text-warning font-weight-bold';
                                        }
                                    }
                                    ?>

                                    <tr>
                                        <td><?php echo $pagamento->id_pagamento ?></td>
                                        <td><?php echo $pagamento->nome_morador ?></td>
                                        <td><?php echo $pagamento->quadra ?></td>
                                        <td><?php echo $pagamento->numero ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($pagamento->data_pagamento)) ?></td>
                                        <td><span class=<?= $class ?>><?php echo date('d/m/Y', strtotime($pagamento->data_vencimento)) ?></span></td>
                                        <td><?php echo $pagamento->referencia ?></td>
                                        <td><?php echo $pagamento->nome_recebedor ?></td>
                                        <td><?php echo number_format($pagamento->valor, 2, ',', '.') ?></td>
                                        <td><?php echo $situacaoClass ?></td>
                                        <td><?php echo $pagamento->desc_forma_pagto ?></td>
                                        <td><?php echo $pagamento->desc_pagamento ?></td>
                                        <td><?php echo $pagamento->observacao ?></td>
                                        <td>
                                            <button title="Editar Registro" type="button"
                                                class="btn btn-primary btn-rounded btn-icon"
                                                onclick="window.location.href='<?php echo base_url('/pagamento/editar/' . $pagamento->id_pagamento) ?>'">
                                                <i class="mdi mdi-pen icon-sm"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="8"></th>
                                    <th>Total</th>
                                    <th colspan="5"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>