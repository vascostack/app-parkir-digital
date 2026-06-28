<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('user', function ($routes) {
    // Akses ke http://localhost:8080/user otomatis ke dashboard
    $routes->get('/', 'UserController::dashboard'); 
    
    // Rute untuk masing-masing halaman sesuai file di folder user
    $routes->get('dashboard', 'UserController::dashboard'); // /user/dashboard
    $routes->get('booking', 'UserController::booking');     // /user/booking
    $routes->get('vehicles', 'UserController::vehicles');   // /user/vehicles
    $routes->get('history', 'UserController::history');     // /user/history
    $routes->get('profile', 'UserController::profile');     // /user/profile
});

