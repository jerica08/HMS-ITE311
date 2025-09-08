<?php

namespace App\Controllers;

class Laboratorist extends BaseController
{
    private function checkLaboratoristAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'laboratorist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Laboratorists only.');
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
        $authCheck = $this->checkLaboratoristAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('laboratorist/dashboard', ['currentUser' => $currentUser]);
    }
}
