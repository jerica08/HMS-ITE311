<?php

namespace App\Controllers\Receptionist;

use App\Controllers\Receptionist\ReceptionistBaseController;
use App\Models\PatientModel;

class PatientRegistrationController extends ReceptionistBaseController
{
    protected $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    public function index()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // Fetch recent patients for display
        $patients = $this->patientModel->orderBy('created_at', 'DESC')->limit(10)->findAll();

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'patients' => $patients,
            'title' => 'Patient Registration'
        ]);

        // Render the view with the data
        return view('receptionist/patient-registration/index', $data);
    }

    public function create()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'title' => 'Register New Patient'
        ]);

        // Render the registration form
        return view('receptionist/patient-registration/create', $data);
    }

    public function store()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        // CSRF protection is handled automatically by CodeIgniter

        // Get form data
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'civil_status' => $this->request->getPost('civil_status'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'province' => $this->request->getPost('province'),
            'city' => $this->request->getPost('city'),
            'barangay' => $this->request->getPost('barangay'),
            'zip_code' => $this->request->getPost('zip_code'),
            'insurance_provider' => $this->request->getPost('insurance_provider'),
            'insurance_number' => $this->request->getPost('insurance_number'),
            'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
            'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
            'medical_notes' => $this->request->getPost('medical_notes'),
            'patient_type' => $this->request->getPost('patient_type') ?: 'Outpatient',
            'status' => 'Active',
            'registration_date' => date('Y-m-d H:i:s')
        ];

        // Attempt to save the patient
        if ($this->patientModel->save($data)) {
            // Get the inserted patient data
            $patientId = $this->patientModel->getInsertID();
            $patient = $this->patientModel->find($patientId);
            
            $successMessage = 'Patient registered successfully!';
            if ($patient && isset($patient['patient_id'])) {
                $successMessage .= ' Patient ID: ' . $patient['patient_id'];
            }
            
            return redirect()->to('/receptionist/patient-registration')
                           ->with('success', $successMessage);
        } else {
            // Get validation errors
            $errors = $this->patientModel->errors();
            
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $errors)
                           ->with('error', 'Failed to register patient. Please check the form for errors.');
        }
    }

    public function show($id)
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            return redirect()->to('/receptionist/patient-registration')
                           ->with('error', 'Patient not found.');
        }

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'patient' => $patient,
            'title' => 'Patient Details'
        ]);

        return view('receptionist/patient-registration/show', $data);
    }

    public function edit($id)
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            return redirect()->to('/receptionist/patient-registration')
                           ->with('error', 'Patient not found.');
        }

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'patient' => $patient,
            'title' => 'Edit Patient Information'
        ]);

        return view('receptionist/patient-registration/edit', $data);
    }

    public function update($id)
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        $patient = $this->patientModel->find($id);
        
        if (!$patient) {
            return redirect()->to('/receptionist/patient-registration')
                           ->with('error', 'Patient not found.');
        }

        // CSRF protection is handled automatically by CodeIgniter

        // Get form data (excluding patient_id which shouldn't be updated)
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'last_name' => $this->request->getPost('last_name'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'civil_status' => $this->request->getPost('civil_status'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'province' => $this->request->getPost('province'),
            'city' => $this->request->getPost('city'),
            'barangay' => $this->request->getPost('barangay'),
            'zip_code' => $this->request->getPost('zip_code'),
            'insurance_provider' => $this->request->getPost('insurance_provider'),
            'insurance_number' => $this->request->getPost('insurance_number'),
            'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
            'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
            'medical_notes' => $this->request->getPost('medical_notes'),
            'patient_type' => $this->request->getPost('patient_type'),
            'status' => $this->request->getPost('status')
        ];

        // Attempt to update the patient
        if ($this->patientModel->update($id, $data)) {
            return redirect()->to('/receptionist/patient-registration/show/' . $id)
                           ->with('success', 'Patient information updated successfully!');
        } else {
            // Get validation errors
            $errors = $this->patientModel->errors();
            
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $errors)
                           ->with('error', 'Failed to update patient information. Please check the form for errors.');
        }
    }

    public function search()
    {
        // Check if the user is authenticated as a receptionist
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $authCheck; // Redirect to login if not authenticated
        }

        $searchTerm = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $patientType = $this->request->getGet('patient_type');
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 20;

        $patients = [];
        $totalCount = 0;

        // Build search query
        $query = $this->patientModel;

        if ($searchTerm) {
            $query = $query->groupStart()
                          ->like('patient_id', $searchTerm)
                          ->orLike('first_name', $searchTerm)
                          ->orLike('last_name', $searchTerm)
                          ->orLike('phone', $searchTerm)
                          ->orLike('email', $searchTerm)
                          ->groupEnd();
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        if ($patientType) {
            $query = $query->where('patient_type', $patientType);
        }

        // Get total count for pagination
        $totalCount = $query->countAllResults(false);

        // Get paginated results
        $patients = $query->orderBy('created_at', 'DESC')
                         ->limit($perPage, ($page - 1) * $perPage)
                         ->findAll();

        // Calculate pagination info
        $totalPages = ceil($totalCount / $perPage);

        // Prepare data for the view
        $data = array_merge($this->getCommonViewData(), [
            'patients' => $patients,
            'searchTerm' => $searchTerm,
            'status' => $status,
            'patientType' => $patientType,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalCount' => $totalCount,
            'perPage' => $perPage,
            'title' => 'Search Patients'
        ]);

        return view('receptionist/patient-registration/search', $data);
    }

    /**
     * API endpoint for patient search (AJAX)
     */
    public function searchApi()
    {
        // Check authentication
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $searchTerm = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $patientType = $this->request->getGet('patient_type');
        $limit = (int)($this->request->getGet('limit') ?? 10);

        $query = $this->patientModel;

        if ($searchTerm) {
            $query = $query->groupStart()
                          ->like('patient_id', $searchTerm)
                          ->orLike('first_name', $searchTerm)
                          ->orLike('last_name', $searchTerm)
                          ->orLike('phone', $searchTerm)
                          ->orLike('email', $searchTerm)
                          ->groupEnd();
        }

        if ($status) {
            $query = $query->where('status', $status);
        }

        if ($patientType) {
            $query = $query->where('patient_type', $patientType);
        }

        $patients = $query->orderBy('created_at', 'DESC')
                         ->limit($limit)
                         ->findAll();

        return $this->response->setJSON([
            'patients' => $patients,
            'count' => count($patients)
        ]);
    }

    /**
     * Get patient statistics for dashboard
     */
    public function getPatientStats()
    {
        // Check authentication
        $authCheck = $this->checkReceptionistAuth();
        if ($authCheck) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $stats = $this->patientModel->getPatientStats();
        return $this->response->setJSON($stats);
    }
}
