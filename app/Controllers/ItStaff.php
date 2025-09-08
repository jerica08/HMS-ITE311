<?php

namespace App\Controllers;

class ItStaff extends BaseController
{
    private function checkItStaffAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'it_staff') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. IT Staff only.');
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
        $authCheck = $this->checkItStaffAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('it_staff/dashboard', ['currentUser' => $currentUser]);
    }
}
