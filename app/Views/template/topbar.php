<?php

$role = session('user_role');

?>

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="index.html"><img
                    src="<?php echo base_url('admin'); ?>/images/logo.svg" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="index.html"><img
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