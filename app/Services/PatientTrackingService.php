<?php

namespace App\Services;

use App\Models\PatientModel;

class PatientTrackingService
{
    protected $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    /**
     * Get patient registration tracking statistics
     */
    public function getRegistrationStats()
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $monthStart = date('Y-m-01');

        return [
            // Daily tracking
            'registrations_today' => $this->patientModel->where('DATE(created_at)', $today)->countAllResults(),
            'registrations_yesterday' => $this->patientModel->where('DATE(created_at)', $yesterday)->countAllResults(),
            
            // Weekly tracking
            'registrations_this_week' => $this->patientModel->where('DATE(created_at) >=', $weekStart)->countAllResults(),
            'registrations_last_week' => $this->patientModel->where('DATE(created_at) >=', date('Y-m-d', strtotime('monday last week')))
                                                          ->where('DATE(created_at) <', $weekStart)
                                                          ->countAllResults(),
            
            // Monthly tracking
            'registrations_this_month' => $this->patientModel->where('DATE(created_at) >=', $monthStart)->countAllResults(),
            'registrations_last_month' => $this->patientModel->where('DATE(created_at) >=', date('Y-m-01', strtotime('first day of last month')))
                                                           ->where('DATE(created_at) <', $monthStart)
                                                           ->countAllResults(),
            
            // Total tracking
            'total_patients' => $this->patientModel->countAll(),
            'active_patients' => $this->patientModel->where('status', 'Active')->countAllResults(),
            
            // Recent registrations
            'recent_registrations' => $this->getRecentRegistrations(5)
        ];
    }

    /**
     * Get recent patient registrations
     */
    public function getRecentRegistrations($limit = 10)
    {
        return $this->patientModel->select('id, patient_id, first_name, last_name, gender, patient_type, status, created_at')
                                 ->orderBy('created_at', 'DESC')
                                 ->limit($limit)
                                 ->findAll();
    }

    /**
     * Track new patient registration
     */
    public function trackNewRegistration($patientId)
    {
        $patient = $this->patientModel->where('patient_id', $patientId)->first();
        
        if ($patient) {
            // Log registration activity (you can expand this for audit trails)
            log_message('info', "New patient registered: {$patientId} - {$patient['first_name']} {$patient['last_name']}");
            
            return [
                'success' => true,
                'patient' => $patient,
                'message' => 'Patient registration tracked successfully'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Patient not found'
        ];
    }

    /**
     * Get registration trends (daily registrations for the last 7 days)
     */
    public function getRegistrationTrends($days = 7)
    {
        $trends = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $count = $this->patientModel->where('DATE(created_at)', $date)->countAllResults();
            
            $trends[] = [
                'date' => $date,
                'count' => $count,
                'day_name' => date('l', strtotime($date))
            ];
        }
        
        return $trends;
    }

    /**
     * Get patient type distribution
     */
    public function getPatientTypeDistribution()
    {
        return [
            'outpatient' => $this->patientModel->where('patient_type', 'Outpatient')->countAllResults(),
            'inpatient' => $this->patientModel->where('patient_type', 'Inpatient')->countAllResults(),
            'emergency' => $this->patientModel->where('patient_type', 'Emergency')->countAllResults()
        ];
    }
}
