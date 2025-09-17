<?php

namespace App\Controllers\Admin;
use App\Controllers\Admin\AdminBaseController;
use App\Models\PatientModel;

class PatientManagementController extends AdminBaseController{
    public function index(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Patient Management',
            'currentUser' => $currentUser
        ];

        return view('admin/patient/patient_management', $data);
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