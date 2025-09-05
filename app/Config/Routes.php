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

    // User Management Routes - Fixed to match JavaScript API calls
    $routes->get('users', 'Admin::users');                    // View all users
    $routes->get('users/api', 'Admin::getUsersApi');          // Get users data (API)
    $routes->get('users/statistics', 'Admin::getUserStatistics'); // Get user statistics (API)
    $routes->post('users', 'Admin::createUser');              // Create new user (API)
    $routes->get('users/(:num)', 'Admin::editUser/$1');       // Get user data for editing (API)
    $routes->put('users/(:num)', 'Admin::updateUser/$1');     // Update user (API)
    $routes->post('users/(:num)', 'Admin::updateUser/$1');    // Update user (fallback for browsers that don't support PUT)
    $routes->delete('users/(:num)', 'Admin::deleteUser/$1');  // Delete user (API)
    $routes->post('users/(:num)/reset-password', 'Admin::resetPassword/$1'); // Reset user password (API)
    
    // Legacy routes for form-based operations (if needed)
    $routes->get('users/create', 'Admin::createUserForm');        // Show create user form
    $routes->get('users/(:num)/edit', 'Admin::editUserForm/$1');  // Show edit user form
    $routes->post('users/(:num)/toggle-status', 'Admin::toggleUserStatus/$1'); // Toggle user status

    // Analytics & Reports Routes
    $routes->get('analytics', 'Admin::analytics');                    // Analytics dashboard
    $routes->get('reports', 'Admin::reports');                        // Reports overview
    $routes->get('reports/generate', 'Admin::generateReport');        // Generate custom report
    $routes->post('reports/export', 'Admin::exportReport');           // Export report (PDF/Excel)
    $routes->get('reports/schedule', 'Admin::scheduleReport');        // Schedule automated reports
    $routes->post('reports/schedule', 'Admin::storeScheduledReport'); // Store scheduled report
    
    // System Settings Routes
    $routes->get('system-settings', 'Admin::systemSettings');         // System settings page
    
    // Audit Logs Routes
    $routes->get('audit-logs', 'Admin::auditLogs');                   // Audit logs page
    
    // Financial Management Routes
    $routes->get('financial', 'Admin::financial'); 
    
    // Patient Management Routes
    $routes->get('patient', 'Admin::patient'); 
    $routes->get('patients', 'Admin::patient');

    // Resource Management Routes
    $routes->get('resource', 'Admin::resource'); 

    //Security Access Routes
    $routes->get('security', 'Admin::securityAccess');

    //Communication Routes
    $routes->get('communication', 'Admin::communication'); 
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
