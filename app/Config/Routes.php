<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->group('', ['filter' => 'role:admin'], function ($routes) {
    # MORADOR/USUARIO ROTAS PRIVADAS
    $routes->get('/user/inserir', 'User::inserir');
    $routes->post('/user/inserir', 'User::inserir');
    $routes->get('/users', 'User::index');
    $routes->match(['get', 'post'], 'user/editar/(:num)', 'User::editar/$1');
    $routes->post('/user/gerarPagamentosMorador', 'User::gerarPagamentosMorador'); // Executa a procedure

    # RECEBEDOR
    $routes->get('/recebedor/inserir', 'Recebedor::inserir');
    $routes->post('/recebedor/inserir', 'Recebedor::inserir');
    $routes->get('/recebedores', 'Recebedor::index');
    $routes->match(['get', 'post'], 'recebedor/editar/(:num)', 'Recebedor::editar/$1');

    # PAGAMENTOS
    $routes->get('/pagamento/inserir', 'Pagamento::inserir');
    $routes->post('/pagamento/inserir', 'Pagamento::inserir');
    $routes->get('/pagamentos', 'Pagamento::index');
    $routes->match(['get', 'post'], 'pagamento/editar/(:num)', 'Pagamento::editar/$1');
    $routes->get('/gerarPagamentos', 'Pagamento::gerarPagamentosForm'); // Exibe o formulário
    $routes->post('/gerarPagamentos', 'Pagamento::gerarPagamentos'); // Executa a procedure
    $routes->get('/pagamento/excluir/(:num)', 'Pagamento::excluir/$1');

    # SAÍDAS
    $routes->get('/saida/inserir', 'Saida::inserir');
    $routes->post('/saida/inserir', 'Saida::inserir');
    $routes->get('/saidas', 'Saida::index');
    $routes->match(['get', 'post'], 'saida/editar/(:num)', 'Saida::editar/$1');

    #PAGAMENTO FUNCIONARIOS
    $routes->get('/pagamentoFuncionario/inserir', 'PagamentoFuncionario::inserir');
    $routes->post('/pagamentoFuncionario/inserir', 'PagamentoFuncionario::inserir');
    $routes->get('/pagamentosFuncionarios', 'PagamentoFuncionario::index');
    $routes->match(['get', 'post'], 'pagamentoFuncionario/editar/(:num)', 'PagamentoFuncionario::editar/$1');
    $routes->get('/pagamentoFuncionario/excluir/(:num)', 'PagamentoFuncionario::excluir/$1');

    # TIPO DE PAGAMENTO ROTAS PRIVADAS
    $routes->get('/tipoPagamento/inserir', 'TipoPagamento::inserir');
    $routes->post('/tipoPagamento/inserir', 'TipoPagamento::inserir');
    $routes->get('/tiposPagamento', 'TipoPagamento::index');
    $routes->match(['get', 'post'], 'tipoPagamento/editar/(:num)', 'TipoPagamento::editar/$1');
    $routes->get('/tipoPagamento/desativar/(:num)', 'TipoPagamento::desativar/$1');
    $routes->get('/tipoPagamento/ativar/(:num)', 'TipoPagamento::ativar/$1');

    # FORMA DE PAGAMENTO ROTAS PRIVADAS
    $routes->get('/formaPagamento/inserir', 'FormaPagamento::inserir');
    $routes->post('/formaPagamento/inserir', 'FormaPagamento::inserir');
    $routes->get('/formasPagamento', 'FormaPagamento::index');
    $routes->match(['get', 'post'], 'formaPagamento/editar/(:num)', 'FormaPagamento::editar/$1');
    $routes->get('/formaPagamento/desativar/(:num)', 'FormaPagamento::desativar/$1');
    $routes->get('/formaPagamento/ativar/(:num)', 'FormaPagamento::ativar/$1');

    # ANEXO ROTAS PRIVADAS
    $routes->get('/anexo/upload', 'Anexo::upload');
    $routes->post('/anexo/upload', 'Anexo::upload');
    $routes->get('/anexo/deletar/(:num)', 'Anexo::deletar/$1');

    # FUNCIONARIOS ROTAS PRIVADAS
    $routes->get('/funcionarios', 'Funcionario::index');
    $routes->get('/funcionario/cadastrar', 'Funcionario::cadastrar');
    $routes->post('/funcionario/cadastrar', 'Funcionario::cadastrar');
    $routes->match(['get', 'post'], 'funcionario/editar/(:num)', 'Funcionario::editar/$1');

    # TIPO SAÍDA ROTAS PRIVADAS
    $routes->get('/tipoSaida', 'TipoSaida::index');
    $routes->get('/tipoSaida/cadastrar', 'TipoSaida::cadastrar');
    $routes->post('/tipoSaida/cadastrar', 'TipoSaida::cadastrar');
    $routes->match(['get', 'post'], 'tipoSaida/editar/(:num)', 'TipoSaida::editar/$1');
    $routes->get('/tipoSaida/desativar/(:num)', 'TipoSaida::desativar/$1');
    $routes->get('/tipoSaida/ativar/(:num)', 'TipoSaida::ativar/$1');

    # DASHBOARD ROTAS PRIVADAS
    $routes->post('/caixa/(:num)', 'Dashboard::getCaixaResumo/$1');

});

# ANEXO ROTAS PUBLICAS
$routes->get('/anexos', 'Anexo::index', ['filter' => 'auth']);
$routes->get('/anexo/download/(:any)', 'Anexo::download/$1', ['filter' => 'auth']);

#PAGAMENTO
$routes->get('/pagamento/downloadPagamento/(:segment)', 'Pagamento::downloadPagamento/$1', ['filter' => 'auth']);

#MORADOR
$routes->get('/pagamentos/meus-pagamentos', 'User::pagamentosPorUsuario', ['filter' => 'auth']);

# LOGIN ROTAS PUBLICAS
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

# PÁGINA DE CONSENTIMENTO (sem necessidade de filtro de consentimento)
$routes->get('/consent', 'Auth::consent');  // Página onde o usuário aceita a política de privacidade
$routes->post('/consent/policy', 'Auth::updatePolicy');  // Atualiza o consentimento do usuário

# ROTAS PROTEGIDAS COM O FILTRO DE AUTENTICAÇÃO E CONSENTIMENTO
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);  // Página inicial, requer login e consentimento
$routes->post('/user/alteraSenha', 'User::updateSenhaUsuario', ['filter' => 'auth']);  // Alteração de senha, requer login e consentimento



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
