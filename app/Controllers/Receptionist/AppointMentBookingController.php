<?php

namespace App\Controllers\Receptionist;
use App\Controllers\Receptionist\ReceptionistBaseController;

class AppointmentBookingController extends ReceptionistBaseController
{
    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // For now, we'll use empty data until AppointmentModel is created
        // TODO: Create AppointmentModel and implement appointment functionality
        $appointments = [];

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'appointments' => $appointments,
            'title' => 'Appointment Bookings'
        ]);

        // Render the view with the data
        return view('receptionist/appointment-booking/index', $data);
    }
}