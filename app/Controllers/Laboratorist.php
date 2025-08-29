<?php

namespace App\Controllers;

class Laboratorist extends BaseController
{
    public function index()
    {
        // Check if user is logged in and role is laboratorist
        if (!session()->get('logged_in') || session()->get('role') !== 'laboratorist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Laboratorists only.');
        }

        return view('laboratorist/dashboard'); 
        // Make sure meron kang app/Views/laboratorist/dashboard.php
    }
}
