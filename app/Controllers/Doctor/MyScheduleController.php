<?php

namespace App\Controllers\Doctor;

use App\Controllers\BaseController;

class MyScheduleController extends BaseController
{
    public function __construct()
    {
        // Load necessary helpers and libraries
        helper(['url', 'form']);
    }

    /**
     * Display doctor's schedule page
     */
    public function index()
    {
        // Check if user is logged in and has doctor role
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return redirect()->to('/login')->with('error', 'Please login as a doctor to access this page.');
        }

        $data = [
            'title' => 'My Schedule',
            'user' => [
                'name' => session()->get('first_name') . ' ' . session()->get('last_name'),
                'role' => session()->get('role'),
                'email' => session()->get('email')
            ]
        ];

        return view('doctor/mySchedule/index', $data);
    }
}
