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
$routes->post('auth/heartbeat', 'Auth::heartbeat');      // Session heartbeat endpoint
$routes->get('auth/check-session', 'Auth::checkSession'); // Check session validity endpoint
$routes->post('auth/logout-beacon', 'Auth::logoutBeacon'); // Beacon logout endpoint

// Profile routes (available to all authenticated roles)
$routes->get('profile', 'Profile::index');
$routes->post('profile/update', 'Profile::update');
$routes->post('profile/password', 'Profile::updatePassword');


$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Admin::index');      // Admin dashboard - maps /admin/dashboard to Admin::index
    $routes->get('dashboard/patient-stats', 'Admin::getPatientStatistics'); // Patient statistics API

    // User Management Routes - Fixed to match JavaScript API calls
    $routes->get('users', 'Admin\UserManagementController::index');                    // View all users
    $routes->get('users/api', 'Admin\UserManagementController::api');          // Get users data (API)
    $routes->get('users/statistics', 'Admin\UserManagementController::statistics'); // Get user statistics (API)
    $routes->get('users/staff-without-accounts', 'Admin\UserManagementController::staffWithoutAccounts'); // Staff without user accounts
    $routes->post('users', 'Admin\UserManagementController::create');              // Create new user (API)
    $routes->get('users/(:num)', 'Admin\UserManagementController::edit/$1');       // Get user data for editing (API)
    $routes->put('users/(:num)', 'Admin\UserManagementController::update/$1');     // Update user (API)
    $routes->post('users/(:num)', 'Admin\UserManagementController::update/$1');    // Update user (fallback for browsers that don't support PUT)
    $routes->delete('users/(:num)', 'Admin\UserManagementController::delete/$1');  // Delete user (API)
    $routes->post('users/(:num)/reset-password', 'Admin\UserManagementController::resetPassword/$1'); // Reset user password (API)
    
    // Legacy routes for form-based operations (if needed)
    $routes->get('users/create', 'Admin::createUserForm');        // Show create user form
    $routes->get('users/(:num)/edit', 'Admin::editUserForm/$1');  // Show edit user form
    $routes->post('users/(:num)/toggle-status', 'Admin::toggleUserStatus/$1'); // Toggle user status

    // Analytics & Reports Routes
    $routes->get('analytics', 'Admin\AnalyticsAndReportsController::analytics');
    $routes->get('reports', 'Admin\AnalyticsAndReportsController::index');
    $routes->get('reports/generate', 'Admin\AnalyticsAndReportsController::generate');
    $routes->post('reports/export', 'Admin\AnalyticsAndReportsController::export');
    $routes->get('reports/schedule', 'Admin\AnalyticsAndReportsController::schedule');
    $routes->post('reports/schedule', 'Admin\AnalyticsAndReportsController::storeScheduled');
    
    // System Settings Routes
    $routes->get('system-settings', 'Admin\SystemSettingsController::index');         // System settings page
    $routes->get('systemSettings', 'Admin\SystemSettingsController::index');          // Alternative route for camelCase URL
    
    // Audit Logs Routes
    $routes->get('audit-logs', 'Admin\AuditLogsController::index');                   // Audit logs page
    $routes->get('auditLogs', 'Admin\AuditLogsController::index');                    // Alternative route for camelCase URL
    
    // Financial Management Routes
    $routes->get('financial', 'Admin\FinancialManagementController::index'); 
    
    // Patient Management Routes
    $routes->get('patient', 'Admin\PatientManagementController::index'); 
    $routes->get('patients', 'Admin\PatientManagementController::index');
    $routes->post('patients', 'Admin\PatientManagementController::create');

    // Staff Management Routes
    $routes->get('staff', 'Admin\StaffManagementController::index');
    $routes->get('staff/api', 'Admin\StaffManagementController::api');
    $routes->post('staff/create', 'Admin\StaffManagementController::create');
    $routes->get('staff/edit/(:num)', 'Admin\StaffManagementController::edit/$1');
    $routes->put('staff/update/(:num)', 'Admin\StaffManagementController::update/$1');
    $routes->post('staff/update/(:num)', 'Admin\StaffManagementController::update/$1'); // fallback for browsers
    $routes->delete('staff/delete/(:num)', 'Admin\StaffManagementController::delete/$1');
    $routes->get('staff/(:num)/shifts', 'Admin\StaffManagementController::shifts/$1');
    $routes->get('staff/(:num)/shifts/api', 'Admin\StaffManagementController::shiftsApi/$1');

    // Resource Management Routes
    $routes->get('resource', 'Admin\ResourceManagementController::index'); 

    //Security Access Routes
    $routes->get('security', 'Admin\SecurityAndAccessController::index');
    $routes->get('securityAccess', 'Admin\SecurityAndAccessController::index');

    //Communication Routes
    $routes->get('communication', 'Admin\CommunicationController::index'); 
});

$routes->group('receptionist', function($routes) {
    $routes->get('dashboard', 'Receptionist\ReceptionistController::index');
    $routes->get('dashboard/tracking-stats', 'Receptionist\ReceptionistController::getTrackingStats');
    
    // Patient Registration Routes
    $routes->get('patient-registration', 'Receptionist\PatientRegistrationController::index');
    $routes->get('patient-registration/create', 'Receptionist\PatientRegistrationController::create');
    $routes->post('patient-registration/store', 'Receptionist\PatientRegistrationController::store');
    $routes->get('patient-registration/show/(:num)', 'Receptionist\PatientRegistrationController::show/$1');
    $routes->get('patient-registration/edit/(:num)', 'Receptionist\PatientRegistrationController::edit/$1');
    $routes->post('patient-registration/update/(:num)', 'Receptionist\PatientRegistrationController::update/$1');
    $routes->get('patient-registration/search', 'Receptionist\PatientRegistrationController::search');
    $routes->get('patient-registration/api/search', 'Receptionist\PatientRegistrationController::searchApi');
    $routes->get('patient-registration/api/stats', 'Receptionist\PatientRegistrationController::getPatientStats');
    
    $routes->get('appointments', 'Receptionist::appointments');
    $routes->get('check-in', 'Receptionist::checkIn');
    $routes->get('waiting-room', 'Receptionist::waitingRoom');
    $routes->get('insurance', 'Receptionist::insurance');
});

$routes->group('doctor', function($routes) {
    $routes->get('dashboard', 'Doctor::index'); 
    
    $routes->get('patients', 'Doctor\PatientsController::index');
    $routes->get('appointments', 'Doctor\AppointmentController::index');
    $routes->get('prescriptions', 'Doctor\PrescriptionsController::index');
    $routes->get('medical-records', 'Doctor\MedicalRecordController::index');
    $routes->get('lab-results', 'Doctor\LabResultsController::index');
    $routes->get('ehr', 'Doctor\EHRController::index');
    $routes->get('mySchedule', 'Doctor\MyScheduleController::index');
    // dashed alias for sidebar links
    $routes->get('my-schedule', 'Doctor\MyScheduleController::index');
});

$routes->group('nurse', function($routes) {
    $routes->get('dashboard', 'Nurse::index');
    $routes->get('vitals', 'Nurse\VitalsController::index');
    $routes->get('medication', 'Nurse\MedicationController::index');
    $routes->get('patient-care', 'Nurse\PatientCareController::index');
    $routes->get('shift-report', 'Nurse\ShiftReportController::index');
});

$routes->group('receptionist', function($routes) {
    $routes->get('dashboard', 'Receptionist::index');
    
    // Patient Registration Routes
    $routes->get('patient-registration', 'Receptionist\PatientRegistrationController::index');
    $routes->get('patient-registration/create', 'Receptionist\PatientRegistrationController::create');
    $routes->post('patient-registration/store', 'Receptionist\PatientRegistrationController::store');
    $routes->get('patient-registration/show/(:num)', 'Receptionist\PatientRegistrationController::show/$1');
    $routes->get('patient-registration/edit/(:num)', 'Receptionist\PatientRegistrationController::edit/$1');
    $routes->post('patient-registration/update/(:num)', 'Receptionist\PatientRegistrationController::update/$1');
    $routes->get('patient-registration/search', 'Receptionist\PatientRegistrationController::search');
    
    $routes->get('appointments', 'Receptionist::appointments');
    // API: Doctors by department
    $routes->get('doctors/by-department/(:segment)', 'Receptionist\\DoctorApiController::byDepartment/$1');
    $routes->get('check-in', 'Receptionist::checkIn');
    $routes->get('waiting-room', 'Receptionist::waitingRoom');
    $routes->get('insurance', 'Receptionist::insurance');
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
