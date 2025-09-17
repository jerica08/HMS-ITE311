<?php

namespace App\Controllers;

class Pharmacist extends BaseController
{
    private function checkPharmacistAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pharmacist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Pharmacists only.');
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
        $authCheck = $this->checkPharmacistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('pharmacist/dashboard', ['currentUser' => $currentUser]);
    }
}