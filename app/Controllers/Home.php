<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Check if user is already logged in
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            if ($role === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
            // For other roles, redirect to admin dashboard for now
            return redirect()->to('/admin/dashboard');
        }
        
        // If not logged in, redirect to login page
        return redirect()->to('/login');
    }
}
