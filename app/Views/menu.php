<?php

function renderMenu($role)
{
?>

    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar" style="z-index: 1040;">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/'); ?>">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">Início</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('/pagamentos/meus-pagamentos'); ?>">
                        <i class="mdi mdi mdi-cash-100 menu-icon"></i>
                        <span class="menu-title">Meus pagamentos</span>
                    </a>
                </li>

                <?php if ($role === 'admin'): ?>
                    <hr class="sidebar-divider mt-0">
                    <li class="nav-item nav-category"><strong>Cadastros</strong></li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/users'); ?>">
                            <i class="mdi mdi-account-multiple menu-icon"></i>
                            <span class="menu-title">Moradores</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/funcionarios'); ?>">
                            <i class="mdi mdi-worker menu-icon"></i>
                            <span class="menu-title">Funcionários</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/recebedores'); ?>">
                            <i class="mdi mdi-account-switch menu-icon"></i>
                            <span class="menu-title">Recebedores</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                    <hr class="sidebar-divider mt-0">

                    <li class="nav-item nav-category"><strong>Financeiro</strong></li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/pagamentos'); ?>">
                            <i class="mdi mdi-cash menu-icon"></i>
                            <span class="menu-title">Pagamentos</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/saidas'); ?>">
                            <i class="mdi mdi-arrow-left-bold-circle menu-icon"></i>
                            <span class="menu-title">Saídas</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/gerarPagamentos'); ?>">
                            <i class="mdi mdi-cash-multiple menu-icon"></i>
                            <span class="menu-title">Gerar Pagamentos</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/pagamentosFuncionarios'); ?>">
                            <i class="mdi mdi-cash menu-icon"></i>
                            <span class="menu-title">Pagamentos Funcionários</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if ($role === 'admin'): ?>

                    <hr class="sidebar-divider mt-0">

                    <li class="nav-item nav-category"><strong>Cadastros Base</strong></li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/formasPagamento'); ?>">
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                            <span class="menu-title">Formas de Pagamento</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/tiposPagamento'); ?>">
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                            <span class="menu-title">Tipos de Pagamento</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/tipoSaida'); ?>">
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                            <span class="menu-title">Tipos de Saída</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('/anexos'); ?>">
                            <i class="mdi mdi-file-document-box menu-icon"></i>
                            <span class="menu-title">Anexos</span>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">User Pages</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="auth">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="#"> Login </a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"> Login 2 </a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"> Register </a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"> Register 2 </a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"> Lockscreen </a></li>
                    </ul>
                </div>
                </li> -->
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
            <?php
        }
            ?>