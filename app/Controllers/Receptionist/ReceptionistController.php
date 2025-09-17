<?php

namespace App\Controllers\Receptionist;

class ReceptionistController extends ReceptionistBaseController
{
    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authError = $this->checkReceptionistAuth();
        if ($authError) {
            return $authError;
        }

        // Prepare data for the view
        $data = $this->getCommonViewData();
        $data['title'] = 'Receptionist Dashboard';

        // Load the dashboard view
        return view('receptionist/dashboard/index', $data);
    }
}
