<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->get('register', 'Auth::register');
$routes->get('/admin/dashboard', 'Admin::dashboard');
$routes->get('/petugas/dashboard', 'Petugas::dashboard');

$routes->post('/register', 'Auth::store');
$routes->post('login', 'Auth::attemptLogin');
