<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Admin Controller - Handles all admin-related functionality
 * This controller manages the admin dashboard, user management, and admin operations
 */
class Admin extends BaseController
{
    // Store session service for user authentication
    protected $session;
    
    // Store UserModel instance for database operations
    protected $userModel;

    /**
     * Constructor - Runs when Admin controller is instantiated
     * Initializes session service and UserModel
     */
    public function __construct()
    {
        // Get the session service to manage user sessions
        $this->session = service('session');
        
        // Create new instance of UserModel for database operations
        $this->userModel = new UserModel();
    }

    /**
     * Dashboard method - Main admin dashboard page
     * Displays overview statistics and admin information
     * 
     * @return string Rendered dashboard view
     */
    public function index()
    {
        // Security check: Verify user is logged in and has admin role
        if (!$this->isAdmin()) {
            // If not admin, redirect to login with error message
            return redirect()->to('/login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Prepare admin user data for the view
        $adminData = [
            'username' => $this->session->get('username'),  // Get username from session
            'role' => $this->session->get('role')           // Get role from session
        ];

        // Get dashboard statistics (patient count, appointments, etc.)
        $stats = $this->getDashboardStats();

        // Get flash messages for display
        $flashMessages = [
            'success' => $this->session->getFlashdata('success'),
            'error' => $this->session->getFlashdata('error')
        ];

        // Return the admin dashboard view with data
        return view('admin/dashboard', [
            'admin' => $adminData,  // Pass admin info to view
            'stats' => $stats,      // Pass statistics to view
            'messages' => $flashMessages  // Pass flash messages to view
        ]);
    }

    /**
     * Users management page - Shows all users in the system
     * Allows admin to view, edit, and manage user accounts
     * 
     * @return string Rendered users management view
     */
    public function users()
    {
        // Security check: Verify user is logged in and has admin role
        if (!$this->isAdmin()) {
            // If not admin, redirect to login with error message
            return redirect()->to('/login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Fetch all users from database using UserModel
        $users = $this->userModel->findAll();
        
        // Return the users management view with data
        return view('admin/users', [
            'admin' => [
                'username' => $this->session->get('username'),  // Get username from session
                'role' => $this->session->get('role')           // Get role from session
            ],
            'users' => $users  // Pass all users data to view
        ]);
    }

    /**
     * Profile page - Shows admin's own profile information
     * Allows admin to view and edit their personal details
     * 
     * @return string Rendered profile view
     */
    public function profile()
    {
        // Security check: Verify user is logged in and has admin role
        if (!$this->isAdmin()) {
            // If not admin, redirect to login with error message
            return redirect()->to('/login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Find current admin user in database using email from session
        $user = $this->userModel->where('email', $this->session->get('email'))->first();
        
        // Return the profile view with data
        return view('admin/profile', [
            'admin' => [
                'username' => $this->session->get('username'),  // Get username from session
                'role' => $this->session->get('role')           // Get role from session
            ],
            'user' => $user  // Pass current user data to view
        ]);
    }

    /**
     * Logout method - Destroys user session and redirects to login
     * Clears all user data and returns to login page
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to login page
     */
    public function logout()
    {
        // Destroy the current user session (removes all session data)
        $this->session->destroy();
        
        // Redirect to login page with success message
        return redirect()->to('/login')->with('success', 'Successfully logged out');
    }
    
    /**
     * Private method to check if current user is admin
     * Verifies both login status and admin role
     * 
     * @return bool True if user is logged in and is admin, false otherwise
     */
    private function isAdmin()
    {
        // Check if user is logged in AND has admin role
        return $this->session->get('logged_in') && 
               $this->session->get('role') === 'admin';
    }

    /**
     * Private method to get dashboard statistics
     * Currently returns sample data, later can connect to real database
     * 
     * @return array Array of dashboard statistics
     */
    private function getDashboardStats()
    {
        // For now, return sample data. Later you can connect to real database
        // These numbers represent typical hospital management metrics
        return [
            'total_patients' => 1250,        // Total number of patients in system
            'available_beds' => 45,          // Number of available hospital beds
            'today_appointments' => 28,      // Appointments scheduled for today
            'revenue_summary' => '$45,250',  // Total revenue for current period
            'pending_bills' => 12,           // Number of unpaid bills
            'inventory_alerts' => 3,         // Low stock alerts for supplies
            'staff_on_duty' => 89            // Staff currently working
        ];
    }
}