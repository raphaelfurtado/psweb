<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="template-demo">
                    <a href="<?php echo base_url($link) ?>" class="btn btn-primary text-white">
                        <i class="mdi mdi-plus btn-icon-prepend"></i>
                        Adicionar
                    </a>
                </div>
                <br />
                <h4 class="card-title"><?php echo $titulo ?></h4>
                <div class="table-responsive">
                <table id="dataTableMoradores"  class="datatable table table-striped nowrap" style="width:100%">
            <thead>
                <tr>
                    <!-- <th class="px-4 py-2">Código</th> -->
                    <th class="desktop mobile tablet">Nome</th>
                    <th class="desktop mobile tablet">Telefone</th>
                    <th class="desktop mobile tablet">Telefone 2</th>
                    <th class="desktop mobile tablet">Quadra</th>
                    <th class="desktop mobile tablet">Número</th>
                    <th class="desktop mobile tablet">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($moradores)): ?>
                    <?php foreach ($moradores as $morador): ?>
                        <tr>
                            <!-- <td class="px-4 py-2"><?php //echo $morador->id 
                                                        ?></td> -->
                            <td><?php echo $morador->nome ?></td>
                            <td><?php echo $morador->telefone ?? 'Não informado'; ?></td>
                            <td><?php echo $morador->telefone_2 ?? 'Não informado'; ?></td>
                            <td><?php echo $morador->quadra ?? 'Não informado'; ?></td>
                            <td><?php echo $morador->numero ?? 'Não informado'; ?></td>
                            <td>
                                <a href="<?php echo base_url('/user/editar/' . $morador->id_user) ?>"
                                    class="text-blue-500 hover:underline">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-4">Nenhum morador encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('template/footer'); ?>