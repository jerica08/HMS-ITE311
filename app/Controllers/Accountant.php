<?php

namespace App\Controllers;

class Accountant extends BaseController
{
    private function checkAccountantAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'accountant') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Accountants only.');
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
        $authCheck = $this->checkAccountantAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('accountant/dashboard', ['currentUser' => $currentUser]);
    }
}