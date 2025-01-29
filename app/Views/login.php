<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PSWEB | Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo base_url('admin'); ?>/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?php echo base_url('admin'); ?>/images/favicon-psweb.png" />

    <link rel="manifest" href="../manifest.json">
    <meta name="theme-color" content="#007bff">
    <link rel="icon" sizes="192x192" href="../icons/favicon-psweb.png">
    <link rel="apple-touch-icon" sizes="192x192" href="../icons/favicon-psweb.png">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                                    <strong>PSWEB informa:</strong> <?php echo session()->getFlashdata('error'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                                    <strong>PSWEB informa:</strong> <?php echo session()->getFlashdata('error'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <br />
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
                                        <input type="text" class="form-control form-control-lg border-left-0 telefone"
                                            id="telefone" name="telefone" placeholder="(99)99999-9999" maxlength="14"
                                            minlength="14">
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
                                <div class="text-center mt-4 font-weight-light">
                                    <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#politicaPrivacidadeDialog">
                                        Politica de privacidade.
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 moradores-half-bg d-flex flex-row">
                        <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright
                            &copy;2025
                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#softbeanAdDialog">
                                SoftBean.
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>

        <!-- Modal da Política de Privacidade -->
        <div id="politicaPrivacidadeDialog" class="modal fade" tabindex="-1" role="dialog"
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
                            <br />
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
                            <br />
                            <h5>Tratamento dos Dados Pessoais</h5>
                            <p>Os dados pessoais coletados e armazenados no sistema têm como finalidade exclusiva a
                                gestão
                                financeira do loteamento e a prestação de contas. Não utilizamos seus dados para outros
                                fins
                                que não sejam aqueles explicitados nesta política.</p>
                            <br />
                            <h5>Quais Dados Coletamos?</h5>
                            <p>Para que o sistema funcione corretamente, coletamos e armazenamos os seguintes dados:</p>
                            <ul>
                                <li>Nome completo, telefone e endereço do morador;</li>
                                <li>Informações relacionadas aos pagamentos, como valores, datas e status (pago/em
                                    aberto);
                                </li>
                                <li>Dados necessários para identificação do lote (número, quadra, entre outros).</li>
                            </ul>
                            <br />
                            <h5>Transparência e Segurança</h5>
                            <p>Garantimos que todas as informações armazenadas são tratadas de forma segura e
                                confidencial.
                                Apenas os administradores do sistema, autorizados pela associação de moradores, têm
                                acesso
                                aos dados pessoais, e isso ocorre exclusivamente para os fins descritos acima.</p>
                            <br />
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
                                meio do e-mail <a
                                    href="mailto:raphaelaraujo075@gmail.com">raphaelaraujo075@gmail.com</a> ou
                                do telefone/whatsapp <a href="tel:+5591983759167">(91) 98375-9167</a>.</p>
                            <br />
                            <h5>Compartilhamento de Informações</h5>
                            <p>Os dados pessoais coletados não serão compartilhados com terceiros, exceto em situações
                                previstas em lei ou mediante sua autorização explícita.</p>
                            <br />
                            <h5>Alterações na Política</h5>
                            <p>Esta Política de Privacidade pode ser alterada de tempos em tempos para refletir
                                melhorias no
                                sistema ou atender a novas exigências legais. Sempre que ocorrerem mudanças, você será
                                informado(a) e terá acesso à nova versão do documento.</p>
                            <br />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal de Propaganda da Softbean -->
        <div id="softbeanAdDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="softbeanAdLabel"
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
                            <br />
                            <h5>Por que escolher a Softbean?</h5>
                            <ul class="list-star">
                                <li><strong>Personalização Completa:</strong> Sistemas feitos sob medida, adaptados às
                                    demandas do seu negócio.</li>
                                <li><strong>Agilidade e Inovação:</strong> Utilizamos tecnologias de ponta para garantir
                                    eficiência e resultados rápidos.</li>
                                <li><strong>Suporte Especializado:</strong> Nossa equipe está sempre pronta para te
                                    atender.</li>
                            </ul>
                            <br />
                            <h5>Entre em Contato</h5>
                            <br />
                            <div class="row">
                                <div class="col-md-5">
                                    <h6>👤 <strong>Raphael Araújo Furtado</strong></h6>
                                    <ul class="list-ticked">
                                        <li><strong>Cel/WhatsApp:</strong> <a href="tel:+NUMERO_RAPHAEL">(91)
                                                98064-7336</a>
                                        </li>
                                        <li><strong>E-mail:</strong> <a
                                                href="mailto:EMAIL_RAPHAEL">raphaelaraujo075@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h6>👤 <strong>Victor Pereira da Silva</strong></h6>
                                    <ul class="list-ticked">
                                        <li><strong>Cel/WhatsApp:</strong> <a href="tel:+EMAIL_VICTOR">(91)
                                                98339-0797</a>
                                        </li>
                                        <li><strong>E-mail:</strong> <a
                                                href="mailto:EMAIL_VICTOR">victorps91@gmail.com</a>
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
        <!-- page-body-wrapper ends -->
    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.telefone').mask("(99)99999-9999");
        });
    </script>


    <script>
        // Registrar o Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('./service-worker.js')
                .then((registration) => {
                    console.log('Service Worker registrado com sucesso:', registration);
                })
                .catch((error) => {
                    console.log('Falha ao registrar o Service Worker:', error);
                });
        }

        // Gerenciar o evento beforeinstallprompt
        let deferredPrompt;
        const installButton = document.getElementById('installButton');

        window.addEventListener('beforeinstallprompt', (event) => {
            console.log('Evento beforeinstallprompt disparado!');
            event.preventDefault();
            deferredPrompt = event;

            // Mostra o botão de instalação
            installButton.style.display = 'block';

            installButton.addEventListener('click', () => {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('Usuário aceitou a instalação');
                    } else {
                        console.log('Usuário recusou a instalação');
                    }
                    deferredPrompt = null;
                });
            });
        });

        // Verificar se o PWA já está instalado
        window.addEventListener('appinstalled', () => {
            console.log('PWA instalado com sucesso!');
            installButton.style.display = 'none';
        });
    </script>

</body>

</html>