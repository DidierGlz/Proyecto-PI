<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('users', 'Users::index');
$routes->get('users/create', 'Users::create');
$routes->post('users', 'Users::store');
$routes->get('users/(:num)/edit', 'Users::edit/$1');
$routes->post('users/(:num)', 'Users::update/$1');
$routes->post('users/(:num)/delete', 'Users::delete/$1');
$routes->get('login', 'Auth::loginForm');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::registerForm');
$routes->post('register', 'Auth::register');

// Protege el CRUD con 'auth' (requiere sesion):
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users', 'Users::store');
    $routes->get('users/(:num)/edit', 'Users::edit/$1');
    $routes->post('users/(:num)', 'Users::update/$1');
    $routes->post('users/(:num)/delete', 'Users::delete/$1');

    // imagenes (nuevo)
    $routes->get('images', 'Images::index');
    $routes->post('images/upload', 'Images::upload');
    $routes->post('images/(:num)/delete', 'Images::delete/$1');

    // ==== Panel de documentos ====
    $routes->get('documents', 'Documents::index');
    $routes->get('documents/word', 'Documents::word');
    $routes->get('documents/excel', 'Documents::excel');
    $routes->get('documents/pdf', 'Documents::pdf');
});
