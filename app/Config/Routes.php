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


$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::index');      // Admin dashboard - maps /admin/dashboard to Admin::index
    
    // User Management Routes
    $routes->get('users', 'Admin::users');                    // View all users
    $routes->get('users/create', 'Admin::createUser');        // Show create user form
    $routes->post('users/store', 'Admin::storeUser');         // Store new user
    $routes->get('users/(:num)', 'Admin::viewUser/$1');       // View specific user
    $routes->get('users/(:num)/edit', 'Admin::editUser/$1');  // Show edit user form
    $routes->post('users/(:num)/update', 'Admin::updateUser/$1'); // Update user
    $routes->delete('users/(:num)/delete', 'Admin::deleteUser/$1'); // Delete user (admin only)
    $routes->post('users/(:num)/toggle-status', 'Admin::toggleUserStatus/$1'); // Toggle user status
    $routes->post('users/(:num)/reset-password', 'Admin::resetPassword/$1'); // Reset user password// Admin dashboard - maps /admin/dashboard to Admin::index       // Admin logout - maps /admin/logout to Admin::logout
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



$routes->group('it_staff', function($routes) {
    $routes->get('dashboard', 'it_staff::index');
});


$routes->group('laboratorist', function($routes) {
    $routes->get('dashboard', 'Laboratorist::index');
});

