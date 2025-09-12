<?php

namespace App\Controllers\Receptionist;

use App\Controllers\Receptionist\ReceptionistBaseController;

class CheckInController extends ReceptionistBaseController
{
    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // Load any necessary models or helpers here
        // For example, loading a Patient model
        $patientModel = new \App\Models\PatientModel();

        // Fetch patients or any other data needed for the view
        $patients = $patientModel->findAll();

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'patients' => $patients,
            'title' => 'Patient Check-In'
        ]);

        // Render the view with the data
        return view('receptionist/check-in/index', $data);
    }
}