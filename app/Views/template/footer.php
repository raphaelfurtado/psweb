<?php

$role = session('user_role');

?>

</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->

<style>
    .bottom-navbar .nav-item.active .menu-icon {
        color: #E11D48;
        /* Vermelho vibrante para itens ativos */
    }

    .bottom-navbar .nav-item.active .menu-title {
        color: #E11D48;
        /* Vermelho vibrante para texto ativo */
    }

    .bottom-navbar .nav-link {
        flex-direction: column;
        padding: 0.5rem 0;
    }

    .bottom-navbar .menu-icon {
        font-size: 1.5rem;
    }

    .bottom-navbar .menu-title {
        font-size: 0.75rem;
    }

    body {
        padding-bottom: 60px;
        /* Espaço para o menu fixo */
    }
</style>

<nav class="bottom-navbar fixed-bottom d-md-none" style="background-color: #1E293B; border-top: 1px solid #374151;">
    <div class="container justify-content-around">
        <ul class="nav page-navigation w-100 justify-content-around">
            <li class="nav-item">
                <a class="nav-link text-center text-light" href="<?php echo base_url('/'); ?>">
                    <i class="mdi mdi-home-outline menu-icon" style="font-size: 1.5rem; color: #4F46E5;"></i>
                    <span class="menu-title d-block" style="font-size: 0.75rem; color: #A1A1AA;">Inicio</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-center text-light"
                    href="<?php echo base_url('/pagamentos/meus-pagamentos'); ?>">
                    <i class="mdi mdi mdi-cash-100 menu-icon" style="font-size: 1.5rem; color: #4F46E5;"></i>
                    <span class="menu-title d-block" style="font-size: 0.75rem; color: #A1A1AA;">Meus Pagamentos</span>
                </a>
            </li>
            <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-center text-light" href="<?php echo base_url('/users'); ?>">
                        <i class="mdi mdi-account-multiple menu-icon" style="font-size: 1.5rem; color: #4F46E5;"></i>
                        <span class="menu-title d-block" style="font-size: 0.75rem; color: #A1A1AA;">Moradores</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-center text-light" href="<?php echo base_url('/pagamentos'); ?>">
                        <i class="mdi mdi-cash menu-icon" style="font-size: 1.5rem; color: #4F46E5;"></i>
                        <span class="menu-title d-block" style="font-size: 0.75rem; color: #A1A1AA;">Pagamentos</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">
            Copyright © bootstrapdash.com 2020
        </span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#softbeanAdDialogLogged">
                Desenvolvido por SoftBean
            </a>
        </span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#politicaPrivacidadeDialogLogged">
                Politica de privacidade.
            </a>
        </span>
    </div>
</footer>

<div id="politicaPrivacidadeDialogLogged" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="politicaPrivacidadeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="politicaPrivacidadeLabel">Política de Privacidade</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-sample" action="<?= base_url('updatePolicy') ?>" method="POST">
                    <p>Nosso sistema foi desenvolvido com o objetivo de oferecer transparência e praticidade na
                        gestão das taxas de pagamento do loteamento fechado Porta do Sol.</p>
                    <h5>Finalidade do Sistema</h5>
                    <p>O sistema é utilizado para os seguintes propósitos principais:</p>
                    <ul>
                        <li><strong>Exibição de Pagamentos Realizados:</strong> Permitir que você consulte os
                            pagamentos realizados, incluindo valores pagos, datas e possíveis pendências,
                            garantindo
                            maior controle sobre suas obrigações financeiras.</li>
                        <li><strong>Prestação de Contas da Associação de Moradores:</strong> Disponibilizar
                            informações sobre receitas, despesas e investimentos, para que você acompanhe e
                            audite a
                            gestão dos recursos de maneira clara e acessível.</li>
                    </ul>
                    <h5>Tratamento dos Dados Pessoais</h5>
                    <p>Os dados pessoais coletados e armazenados no sistema têm como finalidade exclusiva a
                        gestão
                        financeira do loteamento e a prestação de contas. Não utilizamos seus dados para outros
                        fins
                        que não sejam aqueles explicitados nesta política.</p>
                    <h5>Quais Dados Coletamos?</h5>
                    <p>Para que o sistema funcione corretamente, coletamos e armazenamos os seguintes dados:</p>
                    <ul>
                        <li>Nome completo, telefone e endereço do morador;</li>
                        <li>Informações relacionadas aos pagamentos, como valores, datas e status (pago/em
                            aberto);
                        </li>
                        <li>Dados necessários para identificação do lote (número, quadra, entre outros).</li>
                    </ul>
                    <h5>Transparência e Segurança</h5>
                    <p>Garantimos que todas as informações armazenadas são tratadas de forma segura e
                        confidencial.
                        Apenas os administradores do sistema, autorizados pela associação de moradores, têm
                        acesso
                        aos dados pessoais, e isso ocorre exclusivamente para os fins descritos acima.</p>
                    <h5>Seus Direitos</h5>
                    <p>Conforme a Lei Geral de Proteção de Dados (LGPD), você, como titular dos dados, possui os
                        seguintes direitos:</p>
                    <ul>
                        <li>Acessar suas informações pessoais armazenadas no sistema;</li>
                        <li>Solicitar correção de dados incompletos, inexatos ou desatualizados;</li>
                        <li>Requerer a exclusão de seus dados pessoais, caso deseje encerrar seu vínculo com a
                            associação;</li>
                        <li>Obter informações detalhadas sobre como seus dados estão sendo tratados.</li>
                    </ul>
                    <p>Para exercer qualquer um desses direitos, entre em contato com a associação de moradores
                        por
                        meio do e-mail <a href="mailto:raphaelaraujo075@gmail.com">raphaelaraujo075@gmail.com</a> ou
                        do telefone/whatsapp <a href="tel:+5591983759167">(91) 98375-9167</a>.</p>
                    <h5>Compartilhamento de Informações</h5>
                    <p>Os dados pessoais coletados não serão compartilhados com terceiros, exceto em situações
                        previstas em lei ou mediante sua autorização explícita.</p>
                    <h5>Alterações na Política</h5>
                    <p>Esta Política de Privacidade pode ser alterada de tempos em tempos para refletir
                        melhorias no
                        sistema ou atender a novas exigências legais. Sempre que ocorrerem mudanças, você será
                        informado(a) e terá acesso à nova versão do documento.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Propaganda da Softbean -->
<div id="softbeanAdDialogLogged" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="softbeanAdLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="softbeanAdLabel">Conheça a Softbean</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-sample">
                    <p>🚀 <strong>Transforme suas ideias em soluções digitais com a Softbean!</strong></p>
                    <p>Somos especialistas no desenvolvimento de softwares personalizados para atender às
                        necessidades específicas do seu negócio. De sistemas internos a aplicativos avançados,
                        criamos soluções que impulsionam sua empresa.</p>
                    <h5>Por que escolher a Softbean?</h5>
                    <ul class="list-star">
                        <li><strong>Personalização Completa:</strong> Sistemas feitos sob medida, adaptados às
                            demandas do seu negócio.</li>
                        <li><strong>Agilidade e Inovação:</strong> Utilizamos tecnologias de ponta para garantir
                            eficiência e resultados rápidos.</li>
                        <li><strong>Suporte Especializado:</strong> Nossa equipe está sempre pronta para te
                            atender.</li>
                    </ul>
                    <h5>Entre em Contato</h5>
                    <br />
                    <div class="row">
                        <div class="col-md-5">
                            <h6>👤 <strong>Raphael Araújo Furtado</strong></h6>
                            <ul class="list-ticked">
                                <li><strong>Cel/WhatsApp:</strong> <a href="tel:+NUMERO_RAPHAEL">(91) 98064-7336</a>
                                </li>
                                <li><strong>E-mail:</strong> <a
                                        href="mailto:EMAIL_RAPHAEL">raphaelaraujo075@gmail.com</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <h6>👤 <strong>Victor Pereira da Silva</strong></h6>
                            <ul class="list-ticked">
                                <li><strong>Cel/WhatsApp:</strong> <a href="tel:+EMAIL_VICTOR">(91) 98339-0797</a>
                                </li>
                                <li><strong>E-mail:</strong> <a href="mailto:EMAIL_VICTOR">victorps91@gmail.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <br />
                    <p>💡 <strong>Lógica a serviço da produtividade!</strong></p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- controlador dos alerts na página -->
<script>
    $(document).ready(function () {
        // Fade out the success alert after 3 seconds
        setTimeout(function () {
            $('#success-alert').fadeOut('slow');
        }, 3000);

        // Fade out the error alert after 3 seconds
        setTimeout(function () {
            $('#error-alert').fadeOut('slow');
        }, 3000);
    });
</script>

<!-- plugins:js -->
<script src="<?php echo base_url('admin'); ?>/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="<?php echo base_url('admin'); ?>/vendors/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url('admin'); ?>/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="<?php echo base_url('admin'); ?>/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="<?php echo base_url('admin'); ?>/js/off-canvas.js"></script>
<script src="<?php echo base_url('admin'); ?>/js/hoverable-collapse.js"></script>
<script src="<?php echo base_url('admin'); ?>/js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="<?php echo base_url('admin'); ?>/js/dashboard.js"></script>
<script src="<?php echo base_url('admin'); ?>/js/data-table.js"></script>
<script src="<?php echo base_url('admin'); ?>/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url('admin'); ?>/js/dataTables.bootstrap4.js"></script>
<!-- <script src="< ?php echo base_url('admin'); ?>/js/custom.js"></script> -->
<!-- End custom js for this page-->
<script src="https://code.jquery.com/jquery-3.7.1.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"
    type="text/javascript"></script>
<script src="<?php echo base_url('admin'); ?>/js/jquery.cookie.js" type="text/javascript"></script>
<script src="<?php echo base_url('admin'); ?>/datatables/js/datatables-inicialization.js"
    type="text/javascript"></script>
<script src="<?php echo base_url('admin'); ?>/datatables/js/dataTables.js" type="text/javascript"></script>

<script src="<?php echo base_url('admin'); ?>/datatables/js/dataTables.bootstrap5.js" type="text/javascript"></script>
<script src="<?php echo base_url('admin'); ?>/datatables/js/dataTables.responsive.js" type="text/javascript"></script>
<script src="<?php echo base_url('admin'); ?>/datatables/js/responsive.bootstrap5.js" type="text/javascript"></script>
<script src="<?= base_url('js/dataTables.buttons.js') ?>"></script>
<script src="<?= base_url('js/buttons.dataTables.js') ?>"></script>
<script src="<?= base_url('js/jszip.min.js') ?>"></script>
<script src="<?= base_url('js/buttons.html5.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="<?= base_url('js/custom-alert.js') ?>"></script>
<script src="<?php echo base_url('js/custom.js'); ?>"></script>
<script src="<?php echo base_url('admin'); ?>/js/file-upload.js"></script>
<script src="<?= base_url('js/cep.js') ?>"></script>
<script src="<?= base_url('js/modal.js') ?>"></script>
<script src="<?php echo base_url('js/util.js'); ?>"></script>
</body>

</html>