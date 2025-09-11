<?php

namespace App\Controllers\Doctor;
use App\Controllers\Doctor\DoctorBaseController;

class LabResultsController extends DoctorBaseController
{
    public function index()
    {
        return view('doctor/lab-results/index');
    }
}