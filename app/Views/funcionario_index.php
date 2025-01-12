<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<!-- < ?php echo $this->include('header', array('titulo' => $titulo)); ?> -->

<?php if (session()->getFlashdata('msg_success')): ?>
    <div class="alert alert-success" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_success'); ?>.
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('msg_error')): ?>
    <div class="alert alert-warning" role="alert" id="flash-message">
        <strong>PSWEB informa: </strong><?php echo session()->getFlashdata('msg_error'); ?>.
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if ($role === 'admin'): ?>
                    <div class="template-demo">
                        <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                            <i class="mdi mdi-plus btn-icon-prepend"></i>
                            Adicionar
                        </a>
                    </div>
                <?php endif; ?>
                <br />
                <h4 class="card-title">Funcionários Cadastrados</h4>
                <div class="table-responsive">
                    <table id="dataTableFuncionario" class="table table-striped nowrap table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="desktop tablet mobile">Código</th>
                                <th class="desktop tablet mobile">Funcionário</th>
                                <th class="desktop">CPF</th>
                                <th class="desktop">Salário</th>
                                <th class="desktop">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($informacoes as $funcionario): ?>
                                <tr>
                                    <td><?php echo $funcionario['id']; ?></td>
                                    <td><?php echo $funcionario['nome_completo']; ?></td>
                                    <td><?php echo $funcionario['cpf_formatado']; ?></td>
                                    <td><?php echo $funcionario['salario_formatado']; ?></td>
                                    <td>
                                        <button title="Editar Registro" type="button"
                                            class="btn btn-primary btn-rounded btn-icon"
                                            onclick="window.location.href='<?php echo base_url('/funcionario/editar/' . $funcionario['id']) ?>'">
                                            <i class="mdi mdi-pen icon-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>