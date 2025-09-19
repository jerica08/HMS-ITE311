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

        // Get today's patient registrations using direct database query
        $todayCount = 0;
        try {
            $db = db_connect();
            $today = date('Y-m-d');
            $todayCount = $db->query("SELECT COUNT(*) as count FROM patients WHERE DATE(created_at) = ?", [$today])->getRow()->count;
        } catch (\Exception $e) {
            log_message('error', "Error getting patient count: " . $e->getMessage());
            $todayCount = 0;
        }

        // Prepare tracking data
        $trackingData = [
            'registrations_today' => $todayCount,
            'registrations_this_week' => 0,
            'active_patients' => 0,
            'total_patients' => 0,
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
     * Get patient tracking data directly from model
     */
    private function getPatientTrackingData()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $monthStart = date('Y-m-01');

        // Get recent registrations
        $recentRegistrations = $this->patientModel->select('id, patient_id, first_name, last_name, gender, patient_type, status, created_at')
                                                 ->orderBy('created_at', 'DESC')
                                                 ->limit(5)
                                                 ->findAll();

        return [
            // Daily tracking
            'registrations_today' => $this->patientModel->where('DATE(created_at)', $today)->countAllResults(),
            'registrations_yesterday' => $this->patientModel->where('DATE(created_at)', $yesterday)->countAllResults(),
            
            // Weekly tracking
            'registrations_this_week' => $this->patientModel->where('DATE(created_at) >=', $weekStart)->countAllResults(),
            
            // Monthly tracking
            'registrations_this_month' => $this->patientModel->where('DATE(created_at) >=', $monthStart)->countAllResults(),
            
            // Total tracking
            'total_patients' => $this->patientModel->countAll(),
            'active_patients' => $this->patientModel->where('status', 'Active')->countAllResults(),
            
            // Recent registrations
            'recent_registrations' => $recentRegistrations
        ];
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
