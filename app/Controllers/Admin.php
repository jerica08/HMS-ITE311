<?php

namespace App\Controllers;

use App\Models\UserModel;

class Admin extends BaseController
{
    protected $session;
    protected $userModel;

    public function __construct()
    {
        $this->session = service('session');
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Check if user is logged in and is admin
        if (!$this->isAdmin()) {
            return redirect()->to('/login')->with('error', 'Access denied. Admin privileges required.');
        }

        // Get admin user data
        $adminData = [
            'username' => $this->session->get('username'),
            'role' => $this->session->get('role')
        ];

        // Get dashboard statistics
        $stats = $this->getDashboardStats();

        return view('admin/dashboard', [
            'admin' => $adminData,
            'stats' => $stats
        ]);
    }

    // Additional methods for user management, profile, etc.
    
    private function isAdmin()
    {
        return $this->session->get('logged_in') && 
               $this->session->get('role') === 'admin';
    }
}