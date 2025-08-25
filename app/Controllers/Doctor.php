<?php

namespace App\Controllers;

class Doctor extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is nurse
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }

        return view('/doctor/dashboard');
    }
}