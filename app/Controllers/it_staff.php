<?php

namespace App\Controllers;

class it_staff extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is nurse
        if (!session()->get('logged_in') || session()->get('role') !== 'it_staff') {
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }

        return view('/it_staff/dashboard');
    }
}
