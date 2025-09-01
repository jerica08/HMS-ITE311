<?php

namespace App\Controllers;

use App\Models\UserModel;

class Admin extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    private function checkAdminAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Admins only.');
        }
        return null;
    }

    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        return view('admin/dashboard');
    }
    
    public function users()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;
        
        // Simple test data to avoid database errors
        $data = [
            'users' => [],
            'pager' => null,
            'search' => '',
            'title' => 'User Management'
        ];
        
        return view('admin/users', $data);
    }
}
