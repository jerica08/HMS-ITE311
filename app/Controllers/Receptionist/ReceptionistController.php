<?php

namespace App\Controllers\Receptionist;

use App\Models\PatientModel;

class ReceptionistController extends ReceptionistBaseController
{
    protected $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authError = $this->checkReceptionistAuth();
        if ($authError) {
            return $authError;
        }

        // Get today's patient registrations from database
        $todayCount = 0;
        $totalPatients = 0;
        
        try {
            $db = db_connect();
            $today = date('Y-m-d');
            
            // Count today's registrations and total patients
            $todayCount = $db->query("SELECT COUNT(*) as count FROM patients WHERE DATE(created_at) = ?", [$today])->getRow()->count;
            $totalPatients = $db->query("SELECT COUNT(*) as count FROM patients")->getRow()->count;
            
        } catch (\Exception $e) {
            log_message('error', "Error getting patient count: " . $e->getMessage());
            $todayCount = 0;
            $totalPatients = 0;
        }

        // Prepare tracking data
        $trackingData = [
            'registrations_today' => $todayCount,
            'registrations_this_week' => 0,
            'active_patients' => 0,
            'total_patients' => $totalPatients,
            'registrations_this_month' => 0,
            'registrations_yesterday' => 0,
            'recent_registrations' => []
        ];

        // Prepare data for the view
        $data = $this->getCommonViewData();
        $data['title'] = 'Receptionist Dashboard';
        $data['trackingData'] = $trackingData;

        // Load the dashboard view
        return view('receptionist/dashboard/index', $data);
    }

    /**
     * API endpoint for real-time tracking updates
     */
    public function getTrackingStats()
    {
        // Check authentication
        $authError = $this->checkReceptionistAuth();
        if ($authError) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        // Get only today's registrations
        $todayRegistrations = $this->patientModel->where('DATE(created_at)', date('Y-m-d'))->countAllResults();

        $trackingData = [
            'registrations_today' => $todayRegistrations,
            'registrations_this_week' => 0,
            'active_patients' => 0,
            'total_patients' => 0,
            'registrations_this_month' => 0,
            'registrations_yesterday' => 0
        ];

        return $this->response->setJSON($trackingData);
    }
}
