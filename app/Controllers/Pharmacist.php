<?php

namespace App\Controllers;

class Pharmacist extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is nurse
        if (!session()->get('logged_in') || session()->get('role') !== 'pharmacist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access');
        }

        return view('/pharmacist/dashboard');
    }
}