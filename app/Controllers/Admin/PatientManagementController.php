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

        // Accept JSON or form-encoded data
        $requestData = $this->request->getJSON(true) ?? $this->request->getPost();

        // Normalize helper
        $norm = function ($value) {
            if ($value === null) return null;
            $v = trim((string)$value);
            if ($v === '') return null;
            return $v;
        };

        // Map and normalize fields to match PatientModel allowedFields and validation
        $gender = $norm($requestData['gender'] ?? null);
        if ($gender) {
            $gender = ucfirst(strtolower($gender)); // Male, Female, Other
        }

        $civilStatus = $norm($requestData['civil_status'] ?? null);
        if ($civilStatus) {
            $civilStatus = ucfirst(strtolower($civilStatus)); // Single, Married, Widowed, Separated
        }

        $patientType = $norm($requestData['patient_type'] ?? null);
        if ($patientType) {
            $patientType = ucfirst(strtolower($patientType)); // Outpatient, Inpatient, Emergency
        }

        $status = $norm($requestData['status'] ?? 'Active');
        if ($status) {
            $status = ucfirst(strtolower($status)); // Active, Inactive
        }

        $data = [
            'first_name' => $norm($requestData['first_name'] ?? null),
            'middle_name' => $norm($requestData['middle_name'] ?? null),
            'last_name' => $norm($requestData['last_name'] ?? null),
            'date_of_birth' => $norm($requestData['date_of_birth'] ?? null),
            // age is auto-calculated in model callback but accept provided read-only value if present
            'age' => $requestData['age'] ?? null,
            'gender' => $gender,
            'civil_status' => $civilStatus,
            'phone' => $norm($requestData['phone'] ?? null),
            'email' => $norm($requestData['email'] ?? null),
            'address' => $norm($requestData['address'] ?? null),
            'province' => $norm($requestData['province'] ?? null),
            'city' => $norm($requestData['city'] ?? null),
            'barangay' => $norm($requestData['barangay'] ?? null),
            'zip_code' => $norm($requestData['zip_code'] ?? null),
            'insurance_provider' => $norm($requestData['insurance_provider'] ?? null),
            'insurance_number' => $norm($requestData['insurance_number'] ?? null),
            'emergency_contact_name' => $norm($requestData['emergency_contact_name'] ?? null),
            'emergency_contact_phone' => $norm($requestData['emergency_contact_phone'] ?? null),
            'medical_notes' => $norm($requestData['medical_notes'] ?? null),
            'status' => $status,
            'patient_type' => $patientType,
            'registration_date' => date('Y-m-d'),
        ];

        $patientModel = new PatientModel();

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