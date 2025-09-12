<?php

namespace App\Controllers\Receptionist;
use App\Controllers\Receptionist\ReceptionistBaseController;

class AppointMentBookingController extends ReceptionistBaseController
{
    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // Load any necessary models or helpers here
        // For example, loading an Appointment model
        $appointmentModel = new \App\Models\AppointmentModel();

        // Fetch appointments or any other data needed for the view
        $appointments = $appointmentModel->findAll();

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'appointments' => $appointments,
            'title' => 'Appointment Bookings'
        ]);

        // Render the view with the data
        return view('receptionist/appointment_booking', $data);
    }
}