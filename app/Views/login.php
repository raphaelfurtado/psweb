<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PSWEB - Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo base_url('admin'); ?>/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-warning" role="alert">
                                    <strong>Atenção! </strong><?php echo session()->getFlashdata('error'); ?>.
                                </div>
                            <?php endif; ?>
                                
                            <h4>Bem-Vindo!</h4>
                            <form class="pt-3" method="post">
                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg border-left-0"
                                            id="telefone" name="telefone" placeholder="Telefone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="senha">Senha</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg border-left-0"
                                            id="senha" name="senha" placeholder="Senha">
                                    </div>
                                </div>
                                <div class="my-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        ENTRAR
                                    </button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Não tem conta? <a href="#" class="text-primary">Entre em com a diretoria.</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 moradores-half-bg d-flex flex-row">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy;
                            2025 SoftBean.</p>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src=".<?php echo base_url('admin'); ?>/vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src=".<?php echo base_url('admin'); ?>/js/off-canvas.js"></script>
    <script src=".<?php echo base_url('admin'); ?>/js/hoverable-collapse.js"></script>
    <script src=".<?php echo base_url('admin'); ?>/js/template.js"></script>
    <!-- endinject -->
</body>

</html>