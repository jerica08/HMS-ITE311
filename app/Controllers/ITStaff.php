<?php

namespace App\Controllers;

class ITStaff extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Admins only.');
        }

        return view('ITStaff/dashboard'); // this will call app/Views/ITStaff/dashboard.php
    }
}
