<?php

namespace App\Controllers;

class Receptionist extends BaseController
{
    private function checkReceptionistAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'receptionist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Receptionists only.');
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
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('receptionist/dashboard/index', ['currentUser' => $currentUser]);
    }
}