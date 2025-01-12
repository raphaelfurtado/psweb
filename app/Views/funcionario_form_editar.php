<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                        <i class="mdi mdi-keyboard-return btn-icon-prepend"></i>
                        Voltar
                    </a>
                </div>
                <br />
                <h4 class="card-title text-center"><?php echo $titulo ?></h4>
                <form class="form-sample" action="<?= base_url('/funcionario/editar/' . $funcionario['id']) ?>"
                    method="POST">
                    <!-- DADOS PESSOAIS -->
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-description">
                                        <span class="font-weight-bold">DADOS PESSOAIS</span>
                                    </p>
                                    <div class="form-group">
                                        <label for="nome_completo">Nome Completo:</label>
                                        <input type="text" class="form-control" id="nome_completo" name="nome_completo"
                                            value="<?= esc($funcionario['nome_completo']) ?>" />
                                        <?php if (session('errors.nome_completo')): ?>
                                            <div class="error"><?= session('errors.nome_completo') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="data_nascimento">Data Nascimento:</label>
                                        <input id="data_nascimento" name="data_nascimento" class="form-control"
                                            placeholder="dd/mm/yyyy" oninput="formatInputDate(this)"
                                            value="<?= esc($funcionario['data_nascimento']) ?>" />
                                        <?php if (session('errors.data_nascimento')): ?>
                                            <div class="error"><?= session('errors.data_nascimento') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="cpf">CPF:</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf"
                                            value="<?= esc($funcionario['cpf']) ?>" />
                                        <?php if (session('errors.cpf')): ?>
                                            <div class="error"><?= session('errors.cpf') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="rg">RG:</label>
                                        <input type="text" class="form-control" id="rg" name="rg"
                                            value="<?= esc($funcionario['rg']) ?>" />
                                        <?php if (session('errors.rg')): ?>
                                            <div class="error"><?= session('errors.rg') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="cep">CEP:</label>
                                                <div>
                                                    <input id="cep" name="cep" type="number" class="form-control"
                                                        value="<?= esc($funcionario['cep']) ?>" />
                                                    <?php if (session('errors.cep')): ?>
                                                        <div class="error"><?= session('errors.cep') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="cidade">Cidade:</label>
                                                <div>
                                                    <input id="cidade" name="cidade" type="text" class="form-control"
                                                        value="<?= esc($funcionario['cidade']) ?>" />
                                                    <?php if (session('errors.cidade')): ?>
                                                        <div class="error"><?= session('errors.cidade') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="estado">Estado:</label>
                                                <div>
                                                    <select class="form-control" id="estado" name="estado">
                                                        <option value="">UF</option>
                                                        <?php
                                                        $estados = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                                                        foreach ($estados as $estado):
                                                            ?>
                                                            <option value="<?= $estado ?>"
                                                                <?= esc($funcionario['estado']) == $estado ? 'selected' : '' ?>><?= $estado ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <?php if (session('errors.estado')): ?>
                                                    <div class="error"><?= session('errors.estado') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="endereco_completo">Endereço Completo:</label>
                                        <input type="text" class="form-control" id="endereco_completo"
                                            name="endereco_completo"
                                            value="<?= esc($funcionario['endereco_completo']) ?>" />
                                        <?php if (session('errors.endereco_completo')): ?>
                                            <div class="error"><?= session('errors.endereco_completo') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="complemento">Complemento:</label>
                                        <input type="text" class="form-control" id="complemento" name="complemento"
                                            value="<?= esc($funcionario['complemento']) ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="telefone_whatsapp">Telefone/Whatsapp:</label>
                                        <input type="number" class="form-control" id="telefone_whatsapp"
                                            name="telefone_whatsapp"
                                            value="<?= esc($funcionario['telefone_whatsapp']) ?>" />
                                        <?php if (session('errors.telefone_whatsapp')): ?>
                                            <div class="error"><?= session('errors.telefone_whatsapp') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INFORMAÇÕES BANCÁRIAS -->
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-description">
                                        <span class="font-weight-bold">INFORMAÇÕES DE PAGAMENTO</span>
                                    </p>
                                    <div class="form-group">
                                        <label for="nome_titular_conta">Nome do Titular da Conta:</label>
                                        <input type="text" class="form-control" id="nome_titular_conta"
                                            name="nome_titular_conta"
                                            value="<?= esc($funcionario['nome_titular_conta']) ?>" />
                                        <?php if (session('errors.nome_titular_conta')): ?>
                                            <div class="error"><?= session('errors.nome_titular_conta') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="banco">Banco:</label>
                                        <select id="banco" name="banco" class="form-control"
                                            data-banco-selecionado="<?= esc($banco_selecionado) ?>">
                                        </select>
                                        <?php if (session('errors.banco')): ?>
                                            <div class="error"><?= session('errors.banco') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="agencia">Agência:</label>
                                                <div>
                                                    <input id="agencia" name="agencia" type="number"
                                                        class="form-control"
                                                        value="<?= esc($funcionario['agencia']) ?>" />
                                                    <?php if (session('errors.agencia')): ?>
                                                        <div class="error"><?= session('errors.agencia') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="numero_conta">Número da Conta:</label>
                                                <div>
                                                    <input id="numero_conta" name="numero_conta" type="number"
                                                        class="form-control"
                                                        value="<?= esc($funcionario['numero_conta']) ?>" />
                                                    <?php if (session('errors.numero_conta')): ?>
                                                        <div class="error"><?= session('errors.numero_conta') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('footer'); ?>