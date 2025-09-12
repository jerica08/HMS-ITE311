<?php

namespace App\Controllers\Receptionist;
use App\Controllers\Receptionist\ReceptionistBaseController;

class InsuranceVerificationController extends ReceptionistBaseController
{
    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // For now, we'll use empty data until proper models are created
        // TODO: Create models for insurance verification functionality
        $insuranceProviders = [];
        $verificationHistory = [];

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'insuranceProviders' => $insuranceProviders,
            'verificationHistory' => $verificationHistory,
            'title' => 'Insurance Verification'
        ]);

        // Render the view with the data
        return view('receptionist/insuranceVerification/index', $data);
    }
}