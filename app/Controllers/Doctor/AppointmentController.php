<?php

namespace App\Controllers\Doctor;
use App\Controllers\Doctor\DoctorBaseController;

class AppointmentController extends DoctorBaseController
{
    public function index()
    {
        return view('doctor/appointments/index');
    }
}