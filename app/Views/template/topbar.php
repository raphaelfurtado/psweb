<?php

$role = session('user_role');

?>


<!-- Modal de Alteração de Senha -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Alterar Senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulário de Alteração de Senha -->
                <form action="<?= base_url('/user/alteraSenha') ?>" method="POST">
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nova Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            <span class="input-group-text">
                                <i class="mdi mdi-eye-off" id="showNewPassword"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirmar Nova Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                required>
                            <span class="input-group-text">
                                <i class="mdi mdi-eye-off" id="showConfirmPassword"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="#"><img src="<?php echo base_url('admin'); ?>/images/logo.svg"
                    alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="#"><img
                    src="<?php echo base_url('admin'); ?>/images/logo-mini.svg" alt="logo" /></a>
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <?= $role === 'admin' ?
                        '<span class="mdi mdi mdi-account-key"></span>' :
                        '<span class="mdi mdi mdi-account"></span>'; ?>
                    <span class="nav-profile-name">Conta</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?php echo base_url('/logout'); ?>">
                        <i class="mdi mdi-logout text-primary"></i>
                        Sair
                    </a>
                    <a class="dropdown-item" href="#" id="changePasswordLink">
                        <i class="mdi mdi-lock-open-outline text-primary"></i>
                        Alterar Senha
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>