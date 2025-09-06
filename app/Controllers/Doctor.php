<?php

namespace App\Controllers;

class Doctor extends BaseController
{
    private function checkDoctorAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Doctors only.');
        }
        return null;
    }

    private function getCurrentUserData()
    {
        helper('UserHelper');
        return \App\Helpers\UserHelper::getCurrentUser();
    }

    public function index()
    {
        $authCheck = $this->checkDoctorAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('doctor/dashboard', ['currentUser' => $currentUser]);
    }
}