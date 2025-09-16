<?php

namespace App\Controllers;

class Nurse extends BaseController
{
    private function checkNurseAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Nurses only.');
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
        $authCheck = $this->checkNurseAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('nurse/Dashboard/index', ['currentUser' => $currentUser]);
    }
}