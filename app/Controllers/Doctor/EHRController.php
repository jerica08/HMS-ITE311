<?php
namespace App\Controllers\Doctor;
use App\Controllers\BaseController;

class EHRController extends DoctorBaseController
{
    public function index()
    {
        // Ensure the user is authenticated as a doctor
        $authCheck = $this->checkDoctorAuth();
        if ($authCheck) {
            return $authCheck; // Redirect if not authorized
        }

        $data = array_merge($this->getCommonViewData(), [
            'title' => 'Electronic Health Records',
            // Add any additional data needed for the view here
        ]);

        return view('Doctor/EHR/EHR', $data);
    }
}