<?php

namespace App\Controllers\Admin;
use App\Controllers\Admin\AdminBaseController;
use App\Models\PatientModel;

class PatientManagementController extends AdminBaseController{
    public function index(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        
        // Get patient statistics for the dashboard widgets
        $patientStats = $this->getPatientStats();
        
        $data = [
            'title' => 'Patient Management',
            'currentUser' => $currentUser,
            'patientStats' => $patientStats
        ];

        return view('admin/patient/patient_management', $data);
    }

    /**
     * Get patient statistics for patient management dashboard
     */
    private function getPatientStats()
    {
        try {
            $db = db_connect();
            $today = date('Y-m-d');

            return [
                'total_patients' => $db->query("SELECT COUNT(*) as count FROM patients")->getRow()->count,
                'active_patients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE status = 'Active'")->getRow()->count,
                'registrations_today' => $db->query("SELECT COUNT(*) as count FROM patients WHERE DATE(created_at) = ?", [$today])->getRow()->count,
                'outpatients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE patient_type = 'Outpatient'")->getRow()->count,
                'inpatients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE patient_type = 'Inpatient'")->getRow()->count,
                'emergency_patients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE patient_type = 'Emergency'")->getRow()->count
            ];
        } catch (\Exception $e) {
            log_message('error', "Error getting patient statistics: " . $e->getMessage());
            return [
                'total_patients' => 0,
                'active_patients' => 0,
                'registrations_today' => 0,
                'outpatients' => 0,
                'inpatients' => 0,
                'emergency_patients' => 0
            ];
        }
    }

    public function create(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $requestData = $this->request->getJSON(true) ?? $this->request->getPost();

        $patientModel = new PatientModel();

        $data = [
            'full_name' => $requestData['full_name'] ?? null,
            'age' => $requestData['age'] ?? null,
            'gender' => $requestData['gender'] ?? null,
            'phone' => $requestData['phone'] ?? null,
            'primary_condition' => $requestData['primary_condition'] ?? null,
            'room' => $requestData['room'] ?? null,
            'status' => $requestData['status'] ?? null,
            'patient_type' => $requestData['patient_type'] ?? 'outpatient',
            'last_visit' => $requestData['last_visit'] ?? null,
            'notes' => $requestData['notes'] ?? null,
        ];

        if (!$patientModel->insert($data, true)){
            return $this->response->setStatusCode(422)
                ->setJSON([
                    'status' => 'error',
                    'errors' => $patientModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Patient created successfully',
            'id' => $patientModel->getInsertID()
        ]);
    }
}