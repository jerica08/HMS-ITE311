<?php

namespace App\Controllers\Receptionist;

use App\Controllers\Receptionist\ReceptionistBaseController;

class WaitingRoomController extends ReceptionistBaseController
{
    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // For now, we'll use empty data until proper models are created
        // TODO: Create models for waiting room functionality
        $waitingPatients = [];
        $queueStatus = [];

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'waitingPatients' => $waitingPatients,
            'queueStatus' => $queueStatus,
            'title' => 'Waiting Room Management'
        ]);

        // Render the view with the data
        return view('receptionist/waitingRoom/index', $data);
    }
}
