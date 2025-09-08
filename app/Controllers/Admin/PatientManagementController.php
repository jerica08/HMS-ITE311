<?php

namespace App\Controllers\Admin;
use App\Controllers\Admin\AdminBaseController;

class PatientManagementController extends AdminBaseController{
    public function index(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Patient Management',
            'currentUser' => $currentUser
        ];

        return view('admin/patient/patient_management', $data);
    }

}