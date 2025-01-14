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
                <form class="form-sample" action="<?= base_url('/funcionario/cadastrar') ?>" method="POST">
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
                                            value="<?= old('nome_completo') ?>" />
                                        <?php if (session('errors.nome_completo')): ?>
                                            <div class="error"><?= session('errors.nome_completo') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="data_nascimento">Data Nascimento:</label>
                                        <input id="data_nascimento" name="data_nascimento" class="form-control"
                                            placeholder="dd/mm/yyyy" oninput="formatInputDate(this)"
                                            value="<?= old('data_nascimento') ?>" />
                                        <?php if (session('errors.data_nascimento')): ?>
                                            <div class="error"><?= session('errors.data_nascimento') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="cpf">CPF:</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf"
                                            value="<?= old('cpf') ?>" />
                                        <?php if (session('errors.cpf')): ?>
                                            <div class="error"><?= session('errors.cpf') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="rg">RG:</label>
                                        <input type="text" class="form-control" id="rg" name="rg"
                                            value="<?= old('rg') ?>" />
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
                                                        value="<?= old('cep') ?>" />
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
                                                        value="<?= old('cidade') ?>" />
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
                                                        <option value="AC" <?= old('estado') == 'AC' ? 'selected' : '' ?>>
                                                            AC</option>
                                                        <option value="AL" <?= old('estado') == 'AL' ? 'selected' : '' ?>>
                                                            AL</option>
                                                        <option value="AP" <?= old('estado') == 'AP' ? 'selected' : '' ?>>
                                                            AP</option>
                                                        <option value="AM" <?= old('estado') == 'AM' ? 'selected' : '' ?>>
                                                            AM</option>
                                                        <option value="BA" <?= old('estado') == 'BA' ? 'selected' : '' ?>>
                                                            BA</option>
                                                        <option value="CE" <?= old('estado') == 'CE' ? 'selected' : '' ?>>
                                                            CE</option>
                                                        <option value="DF" <?= old('estado') == 'DF' ? 'selected' : '' ?>>
                                                            DF</option>
                                                        <option value="ES" <?= old('estado') == 'ES' ? 'selected' : '' ?>>
                                                            ES</option>
                                                        <option value="GO" <?= old('estado') == 'GO' ? 'selected' : '' ?>>
                                                            GO</option>
                                                        <option value="MA" <?= old('estado') == 'MA' ? 'selected' : '' ?>>
                                                            MA</option>
                                                        <option value="MT" <?= old('estado') == 'MT' ? 'selected' : '' ?>>
                                                            MT</option>
                                                        <option value="MS" <?= old('estado') == 'MS' ? 'selected' : '' ?>>
                                                            MS</option>
                                                        <option value="MG" <?= old('estado') == 'MG' ? 'selected' : '' ?>>
                                                            MG</option>
                                                        <option value="PA" <?= old('estado') == 'PA' ? 'selected' : '' ?>>
                                                            PA</option>
                                                        <option value="PB" <?= old('estado') == 'PB' ? 'selected' : '' ?>>
                                                            PB</option>
                                                        <option value="PR" <?= old('estado') == 'PR' ? 'selected' : '' ?>>
                                                            PR</option>
                                                        <option value="PE" <?= old('estado') == 'PE' ? 'selected' : '' ?>>
                                                            PE</option>
                                                        <option value="PI" <?= old('estado') == 'PI' ? 'selected' : '' ?>>
                                                            PI</option>
                                                        <option value="RJ" <?= old('estado') == 'RJ' ? 'selected' : '' ?>>
                                                            RJ</option>
                                                        <option value="RN" <?= old('estado') == 'RN' ? 'selected' : '' ?>>
                                                            RN</option>
                                                        <option value="RS" <?= old('estado') == 'RS' ? 'selected' : '' ?>>
                                                            RS</option>
                                                        <option value="RO" <?= old('estado') == 'RO' ? 'selected' : '' ?>>
                                                            RO</option>
                                                        <option value="RR" <?= old('estado') == 'RR' ? 'selected' : '' ?>>
                                                            RR</option>
                                                        <option value="SC" <?= old('estado') == 'SC' ? 'selected' : '' ?>>
                                                            SC</option>
                                                        <option value="SP" <?= old('estado') == 'SP' ? 'selected' : '' ?>>
                                                            SP</option>
                                                        <option value="SE" <?= old('estado') == 'SE' ? 'selected' : '' ?>>
                                                            SE</option>
                                                        <option value="TO" <?= old('estado') == 'TO' ? 'selected' : '' ?>>
                                                            TO</option>
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
                                            name="endereco_completo" value="<?= old('endereco_completo') ?>" />
                                        <?php if (session('errors.endereco_completo')): ?>
                                            <div class="error"><?= session('errors.endereco_completo') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="complemento">Complemento:</label>
                                        <input type="text" class="form-control" id="complemento" name="complemento">
                                    </div>

                                    <div class="form-group">
                                        <label for="telefone_whatsapp">Telefone/Whatsapp:</label>
                                        <input type="number" class="form-control" id="telefone_whatsapp"
                                            name="telefone_whatsapp" value="<?= old('telefone_whatsapp') ?>" />
                                        <?php if (session('errors.telefone_whatsapp')): ?>
                                            <div class="error"><?= session('errors.telefone_whatsapp') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- INFORMAÇÕES BANCARIAS -->
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-description">
                                        <span class="font-weight-bold">INFORMAÇÕES DE PAGAMENTO</span>
                                    </p>
                                    <div class="form-group">
                                        <label for="nome_titular_conta">Nome do Titular da Conta:</label>
                                        <input type="text" class="form-control" id="nome_titular_conta"
                                            name="nome_titular_conta" value="<?= old('nome_titular_conta') ?>" />
                                        <?php if (session('errors.nome_titular_conta')): ?>
                                            <div class="error"><?= session('errors.nome_titular_conta') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="banco">Banco:</label>
                                        <select class="form-control" id="banco" name="banco"></select>
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
                                                        class="form-control" value="<?= old('agencia') ?>" />
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
                                                        class="form-control" value="<?= old('numero_conta') ?>" />
                                                    <?php if (session('errors.numero_conta')): ?>
                                                        <div class="error"><?= session('errors.numero_conta') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label>Tipo de Conta:</label>
                                                <div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="tipo_conta" id="contaRadios1" value="01" checked>
                                                            Corrente
                                                        </label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="tipo_conta" id="contaRadios2" value="02">
                                                            Poupança
                                                        </label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="tipo_conta" id="contaRadios3" value="03">
                                                            Salário
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php if (session('errors.tipo_conta')): ?>
                                                    <div class="error"><?= session('errors.tipo_conta') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="salario">Salário:</label>
                                        <input type="text" class="form-control" id="salario" name="salario"
                                            value="<?= old('salario') ?>">
                                        <?php if (session('errors.salario')): ?>
                                            <div class="error"><?= session('errors.salario') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="chave_pix">Chave PIX:</label>
                                        <input type="text" class="form-control" id="chave_pix" name="chave_pix"
                                            value="<?= old('chave_pix') ?>" />
                                        <?php if (session('errors.chave_pix')): ?>
                                            <div class="error"><?= session('errors.chave_pix') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="observacao">Observações:</label>
                                        <textarea class="form-control" id="observacao" name="observacao"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2"> <?= $acao; ?></button>
                    <a href="<?php echo base_url($link) ?>" class="btn btn-light">
                        Cancelar
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('js/banco.js') ?>"></script>

<?php echo $this->include('template/footer'); ?>