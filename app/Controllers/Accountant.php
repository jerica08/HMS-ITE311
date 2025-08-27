<?php

namespace App\Controllers;

class Accountant extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is nurse
        if (!session()->get('logged_in') || session()->get('role') !== 'accountant') {
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }

        return view('/accountant/dashboard');
    }
}