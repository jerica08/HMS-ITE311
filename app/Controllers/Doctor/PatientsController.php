<?php

namespace App\Controllers\Doctor;

use App\Controllers\Doctor\DoctorBaseController;

class PatientsController extends DoctorBaseController
{
    public function index()
    {
        return view('doctor/patients/index');
    }
}