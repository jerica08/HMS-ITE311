<?php

namespace App\Controllers\Doctor;

use App\Controllers\Doctor\DoctorBaseController;

class PatientsController extends DoctorBaseController
{
    public function index()
    {
        // Check authentication
        $authCheck = $this->checkDoctorAuth();
        if ($authCheck) {
            return $authCheck;
        }

        // Get common view data including current user
        $data = $this->getCommonViewData();
        
        return view('doctor/patients/index', $data);
    }
}