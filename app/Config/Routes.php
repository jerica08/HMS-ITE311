<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/loginSubmit', 'Auth::loginSubmit');
$routes->get('/logout', 'Auth::logout');

// Admin routes with authentication filter
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('dashboard', 'Admin::index');
    $routes->get('users', 'Admin::users');
    $routes->get('profile', 'Admin::profile');
});