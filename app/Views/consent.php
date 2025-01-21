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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Política de Privacidade</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Bem-vindo(a) ao sistema da Associação de Moradores Porta do Sol!</strong></p>
                        <p>
                            Nosso sistema foi desenvolvido com o objetivo de oferecer transparência e praticidade na
                            gestão das taxas de pagamento do loteamento fechado Porta do Sol.
                        </p>

                        <p>Esta página só irá aparecer no seu primeiro acesso.</p>
                        <br />
                        <h5>Finalidade do Sistema</h5>
                        <p>O sistema é utilizado para os seguintes propósitos principais:</p>
                        <ul>
                            <li>
                                <strong>Exibição de Pagamentos Realizados:</strong> Permitir que você consulte os
                                pagamentos realizados, incluindo valores pagos, datas e possíveis pendências, garantindo
                                maior controle sobre suas obrigações financeiras.
                            </li>
                            <li>
                                <strong>Prestação de Contas da Associação de Moradores:</strong> Disponibilizar
                                informações sobre receitas, despesas e investimentos, para que você acompanhe e audite a
                                gestão dos recursos de maneira clara e acessível.
                            </li>
                        </ul>

                        <h5>Tratamento dos Dados Pessoais</h5>
                        <p>
                            Os dados pessoais coletados e armazenados no sistema têm como finalidade exclusiva a gestão
                            financeira do loteamento e a prestação de contas. Não utilizamos seus dados para outros fins
                            que não sejam aqueles explicitados nesta política.
                        </p>

                        <h5>Quais Dados Coletamos?</h5>
                        <p>Para que o sistema funcione corretamente, coletamos e armazenamos os seguintes dados:</p>
                        <ul>
                            <li>Nome completo, telefone e endereço do morador;</li>
                            <li>Informações relacionadas aos pagamentos, como valores, datas e status (pago/em aberto);
                            </li>
                            <li>Dados necessários para identificação do lote (número, quadra, entre outros).</li>
                        </ul>

                        <h5>Transparência e Segurança</h5>
                        <p>
                            Garantimos que todas as informações armazenadas são tratadas de forma segura e confidencial.
                            Apenas os administradores do sistema, autorizados pela associação de moradores, têm acesso
                            aos dados pessoais, e isso ocorre exclusivamente para os fins descritos acima.
                        </p>

                        <h5>Seus Direitos</h5>
                        <p>
                            Conforme a Lei Geral de Proteção de Dados (LGPD), você, como titular dos dados, possui os
                            seguintes direitos:
                        </p>
                        <ul>
                            <li>Acessar suas informações pessoais armazenadas no sistema;</li>
                            <li>Solicitar correção de dados incompletos, inexatos ou desatualizados;</li>
                            <li>Requerer a exclusão de seus dados pessoais, caso deseje encerrar seu vínculo com a
                                associação;</li>
                            <li>Obter informações detalhadas sobre como seus dados estão sendo tratados.</li>
                        </ul>
                        <p>
                            Para exercer qualquer um desses direitos, entre em contato com a associação de moradores por
                            meio do e-mail
                            <a href="mailto:raphaelaraujo075@gmail.com">raphaelaraujo075@gmail.com</a>
                            ou do telefone/whatsapp
                            <a href="tel:+5591983759167">(91) 98375-9167</a>.
                        </p>

                        <h5>Compartilhamento de Informações</h5>
                        <p>
                            Os dados pessoais coletados não serão compartilhados com terceiros, exceto em situações
                            previstas em lei ou mediante sua autorização explícita.
                        </p>

                        <h5>Alterações na Política</h5>
                        <p>
                            Esta Política de Privacidade pode ser alterada de tempos em tempos para refletir melhorias
                            no sistema ou atender a novas exigências legais. Sempre que ocorrerem mudanças, você será
                            informado(a) e terá acesso à nova versão do documento.
                        </p>
                        <p>Ao aceitar, você concorda com o uso de seus dados conforme descrito.</p>
                        <br>

                        <form action="<?= base_url('/consent/policy'); ?>" method="post">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="aceitoPolitica" type="checkbox" class="form-check-input">
                                    Li e concordo com os termos da Política de Privacidade.
                                </label>
                            </div>
                            <button disabled id="aceitarPolitica" type="submit" class="btn btn-primary btn-block">
                                Aceitar e Continuar
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Copyright &copy; <?= date('Y'); ?> SoftBean.</p>
                    </div>
                </div>
            </div>
        </div>
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
        document.addEventListener("DOMContentLoaded", function () {
            const aceitarBtn = document.getElementById("aceitarPolitica");
            const checkbox = document.getElementById("aceitoPolitica");

            // Habilita o botão "Aceitar" apenas se o checkbox for marcado
            checkbox.addEventListener("change", function () {
                aceitarBtn.disabled = !checkbox.checked;
            });
        });
    </script>
</body>

</html>