<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

service('auth')->routes($routes);

$routes->get('/', static function() {
    return redirect()->to('/categorias');
});

// --- Rotas de Categoria ---
$routes->group('categorias', ['filter' => 'session'], static function ($routes) {
    $routes->get('/', 'CategoriaController::index');
    $routes->get('datatable', 'CategoriaController::datatable');
    $routes->get('buscar-ajax', 'CategoriaController::buscarAjax');
    $routes->get('novo', 'CategoriaController::create');
    $routes->post('salvar', 'CategoriaController::store');
    $routes->get('editar/(:num)', 'CategoriaController::edit/$1');
    $routes->post('atualizar/(:num)', 'CategoriaController::update/$1');
    $routes->post('excluir/(:num)', 'CategoriaController::delete/$1');
});

// --- Rotas de Produtos ---
$routes->group('produtos', ['filter' => 'session'], static function ($routes) {
    $routes->get('/', 'ProdutoController::index');
    $routes->get('datatable', 'ProdutoController::datatable');
    $routes->get('novo', 'ProdutoController::create');
    $routes->post('salvar', 'ProdutoController::store');
    $routes->get('editar/(:num)', 'ProdutoController::edit/$1');
    $routes->post('atualizar/(:num)', 'ProdutoController::update/$1');
    $routes->post('excluir/(:num)', 'ProdutoController::delete/$1');
});

$routes->group('api', static function ($routes) {
    $routes->get('categorias', 'Api\CategoriaController::index');
});