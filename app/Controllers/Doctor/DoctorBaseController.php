<?php

namespace App\Controllers\Doctor;

class DoctorBaseController extends BaseController
{
    protected function checkDoctorAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Doctors only.');
        }
        return null;
    }

    protected function getCurrentUserData()
    {
        helper('UserHelper');
        return \App\Helpers\UserHelper::getCurrentUser();
    }

    protected function getCommonViewData()
    {
        return [
            'currentUser' => $this->getCurrentUserData()
        ];
    }
}