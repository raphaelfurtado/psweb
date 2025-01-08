<?php echo $this->include('header', array('titulo' => $titulo)); ?>

<strong class="text-lg text-red-500 mb-4 block text-center sm:text-left"><?php echo $msg ?></strong>

<div id="upload-url" data-url="<?= base_url('/anexo/upload') ?>"></div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
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
                <form class="forms-sample" id="upload-form" action="<?= base_url('/anexo/upload') ?>" method="POST"
                    enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="tipo_anexo">Selecione o Tipo do Arquivo:</label>
                        <select class="form-control" id="tipo_anexo" name="tipo_anexo" required>
                            <option value="">-- Selecione --</option>
                            <option value="1">Associação</option>
                            <option value="2">Morador</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="morador">Selecione o Morador:</label>
                        <select class="form-control" id="morador" name="id_morador" required>
                            <option value="">-- Selecione --</option>
                            <?php foreach ($moradores as $morador): ?>
                                <option value="<?= $morador->id; ?>"><?= $morador->nome; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Titulo</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Título"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="files">Arquivo</label>
                        <input type="file" id="files" name="files[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled
                                placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">
                                    <i class="mdi mdi-folder-upload"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="img[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled
                                placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
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

<!-- < ?php echo $this->include('template/footer'); ?>  -->
<?php echo $this->include('footer'); ?>