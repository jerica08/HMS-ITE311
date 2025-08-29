<?php

use CodeIgniter\Router\RouteCollection;

/**
 * Routes Configuration File
 * This file defines all the URL routes for your Hospital Management System
 * Routes map URLs to controller methods
 */

/**
 * @var RouteCollection $routes - CodeIgniter's route collection object
 * This variable holds all the route definitions
 */
$routes->get('/', 'Home::index');                    // Homepage route - maps root URL to Home controller's index method
$routes->get('/login', 'Auth::login');              // Login page route - maps /login to Auth controller's login method
$routes->get('/auth', 'Auth::login');               // Alternative login route - redirects /auth to login page
$routes->post('auth/loginSubmit', 'Auth::loginSubmit');   // Login form submission route - handles POST requests for login
$routes->get('auth/logout', 'Auth::logout');        // Logout route - maps /auth/logout to Auth controller's logout method


$routes->group('admin',  function($routes) {
    $routes->get('dashboard', 'Admin::index');      // Admin dashboard - maps /admin/dashboard to Admin::index       // Admin logout - maps /admin/logout to Admin::logout
});


$routes->group('doctor', function($routes) {
    $routes->get('dashboard', 'Doctor::index');     
});

$routes->group('nurse', function($routes) {
    $routes->get('dashboard', 'Nurse::index');
});

$routes->group('receptionist', function($routes) {
    $routes->get('dashboard', 'Receptionist::index');
});

$routes->group('pharmacist', function($routes) {
    $routes->get('dashboard', 'Pharmacist::index');
});

$routes->group('accountant', function($routes) {
    $routes->get('dashboard', 'Accountant::index');
});

// IT Staff routes
$routes->group('itstaff', function($routes) {
    $routes->get('/', 'ITStaff::index');                    // GET /itstaff - List all IT staff
    $routes->get('create', 'ITStaff::create');              // GET /itstaff/create - Show create form
    $routes->post('/', 'ITStaff::store');                   // POST /itstaff - Store new IT staff
    $routes->get('edit/(:num)', 'ITStaff::edit/$1');        // GET /itstaff/edit/{id} - Show edit form
    $routes->post('update/(:num)', 'ITStaff::update/$1');   // POST /itstaff/update/{id} - Update IT staff
    $routes->get('delete/(:num)', 'ITStaff::delete/$1');    // GET /itstaff/delete/{id} - Delete IT staff
});

// Laboratories routes
$routes->group('laboratories', function($routes) {
    $routes->get('/', 'Laboratories::index');                    // GET /laboratories - List all laboratories
    $routes->get('create', 'Laboratories::create');              // GET /laboratories/create - Show create form
    $routes->post('/', 'Laboratories::store');                   // POST /laboratories - Store new laboratory
    $routes->get('edit/(:num)', 'Laboratories::edit/$1');        // GET /laboratories/edit/{id} - Show edit form
    $routes->post('update/(:num)', 'Laboratories::update/$1');   // POST /laboratories/update/{id} - Update laboratory
    $routes->get('delete/(:num)', 'Laboratories::delete/$1');    // GET /laboratories/delete/{id} - Delete laboratory
});
