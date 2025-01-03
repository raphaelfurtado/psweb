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
    # MORADOR/USUARIO
    $routes->get('/user/inserir', 'User::inserir');
    $routes->post('/user/inserir', 'User::inserir');
    $routes->get('/users', 'User::index');
    $routes->match(['get', 'post'], 'user/editar/(:num)', 'User::editar/$1');

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



    # TIPO DE PAGAMENTO
    $routes->get('/tipoPagamento/inserir', 'TipoPagamento::inserir');
    $routes->post('/tipoPagamento/inserir', 'TipoPagamento::inserir');
    $routes->get('/tiposPagamento', 'TipoPagamento::index');

    # FORMA DE PAGAMENTO
    $routes->get('/formaPagamento/inserir', 'FormaPagamento::inserir');
    $routes->post('/formaPagamento/inserir', 'FormaPagamento::inserir');
    $routes->get('/formasPagamento', 'FormaPagamento::index');
});

# LOGIN 
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('/', 'Dashboard::index');


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
