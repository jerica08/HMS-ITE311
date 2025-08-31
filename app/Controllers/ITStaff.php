<?php

namespace App\Controllers;

<<<<<<< HEAD
class ItStaff extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is nurse
        if (!session()->get('logged_in') || session()->get('role') !== 'it_staff') {
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }

        return view('/itStaff/dashboard');
    }
}
=======
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
>>>>>>> 53187ca7df75452140087cf622855faf9cc9ce0e
