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

    public function patientRegistration()
    {
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('receptionist/patient-registration/index', ['currentUser' => $currentUser]);
    }

    public function appointments()
    {
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('receptionist/appointment-booking/index', ['currentUser' => $currentUser]);
    }

    public function checkIn()
    {
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('receptionist/checkIn/index', ['currentUser' => $currentUser]);
    }

    public function waitingRoom()
    {
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('receptionist/waitingRoom/index', ['currentUser' => $currentUser]);
    }

    public function insurance()
    {
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('receptionist/insuranceVerification/index', ['currentUser' => $currentUser]);
    }
}