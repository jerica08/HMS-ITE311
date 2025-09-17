<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table            = 'patients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'patient_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'age',
        'gender',
        'civil_status',
        'phone',
        'email',
        'address',
        'province',
        'city',
        'barangay',
        'zip_code',
        'insurance_provider',
        'insurance_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_notes',
        'status',
        'patient_type',
        'registration_date',
        'last_visit'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'first_name' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z\s\-\'\.]+$/]',
        'middle_name' => 'permit_empty|max_length[100]|regex_match[/^[a-zA-Z\s\-\'\.]+$/]',
        'last_name' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z\s\-\'\.]+$/]',
        'date_of_birth' => 'required|valid_date[Y-m-d]',
        'gender' => 'required|in_list[Male,Female,Other]',
        'civil_status' => 'required|in_list[Single,Married,Divorced,Widowed,Separated]',
        'phone' => 'required|min_length[10]|max_length[15]|regex_match[/^[\+]?[0-9\-\(\)\s]+$/]',
        'email' => 'permit_empty|valid_email|max_length[150]',
        'address' => 'required|min_length[10]|max_length[500]',
        'province' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z\s\-\'\.]+$/]',
        'city' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z\s\-\'\.]+$/]',
        'barangay' => 'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z0-9\s\-\'\.]+$/]',
        'zip_code' => 'required|min_length[4]|max_length[10]|regex_match[/^[0-9\-]+$/]',
        'insurance_provider' => 'permit_empty|max_length[100]|regex_match[/^[a-zA-Z0-9\s\-\'\.&]+$/]',
        'insurance_number' => 'permit_empty|max_length[50]|regex_match[/^[a-zA-Z0-9\-]+$/]',
        'emergency_contact_name' => 'required|min_length[2]|max_length[200]|regex_match[/^[a-zA-Z\s\-\'\.]+$/]',
        'emergency_contact_phone' => 'required|min_length[10]|max_length[15]|regex_match[/^[\+]?[0-9\-\(\)\s]+$/]',
        'medical_notes' => 'permit_empty|max_length[1000]',
        'status' => 'permit_empty|in_list[Active,Inactive,Discharged]',
        'patient_type' => 'permit_empty|in_list[Inpatient,Outpatient,Emergency]'
    ];

    protected $validationMessages = [
        'first_name' => [
            'required' => 'First name is required.',
            'min_length' => 'First name must be at least 2 characters long.',
            'max_length' => 'First name cannot exceed 100 characters.',
            'regex_match' => 'First name can only contain letters, spaces, hyphens, apostrophes, and periods.'
        ],
        'last_name' => [
            'required' => 'Last name is required.',
            'min_length' => 'Last name must be at least 2 characters long.',
            'max_length' => 'Last name cannot exceed 100 characters.',
            'regex_match' => 'Last name can only contain letters, spaces, hyphens, apostrophes, and periods.'
        ],
        'date_of_birth' => [
            'required' => 'Date of birth is required.',
            'valid_date' => 'Please enter a valid date of birth in YYYY-MM-DD format.'
        ],
        'phone' => [
            'required' => 'Phone number is required.',
            'regex_match' => 'Please enter a valid phone number.'
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['generatePatientId', 'calculateAge'];
    protected $beforeUpdate   = ['calculateAge'];

    /**
     * Generate unique patient ID
     */
    protected function generatePatientId(array $data)
    {
        if (!isset($data['data']['patient_id']) || empty($data['data']['patient_id'])) {
            $data['data']['patient_id'] = $this->generateUniquePatientId();
        }
        return $data;
    }

    /**
     * Calculate age from date of birth
     */
    protected function calculateAge(array $data)
    {
        if (isset($data['data']['date_of_birth'])) {
            $dob = new \DateTime($data['data']['date_of_birth']);
            $now = new \DateTime();
            $data['data']['age'] = $now->diff($dob)->y;
        }
        return $data;
    }

    /**
     * Generate unique patient ID
     */
    private function generateUniquePatientId(): string
    {
        do {
            $patientId = 'P' . date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $exists = $this->where('patient_id', $patientId)->first();
        } while ($exists);

        return $patientId;
    }

    /**
     * Get patient's full name
     */
    public function getFullName(array $patient): string
    {
        $fullName = $patient['first_name'];
        
        if (!empty($patient['middle_name'])) {
            $fullName .= ' ' . $patient['middle_name'];
        }
        
        $fullName .= ' ' . $patient['last_name'];
        
        return $fullName;
    }

    /**
     * Search patients by various criteria
     */
    public function searchPatients($searchTerm, $limit = 10)
    {
        return $this->groupStart()
                    ->like('patient_id', $searchTerm)
                    ->orLike('first_name', $searchTerm)
                    ->orLike('last_name', $searchTerm)
                    ->orLike('phone', $searchTerm)
                    ->orLike('email', $searchTerm)
                    ->groupEnd()
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get patients by status
     */
    public function getPatientsByStatus($status = 'Active')
    {
        return $this->where('status', $status)->findAll();
    }

    /**
     * Get patients by type
     */
    public function getPatientsByType($type)
    {
        return $this->where('patient_type', $type)->findAll();
    }

    /**
     * Update last visit date
     */
    public function updateLastVisit($patientId)
    {
        return $this->where('patient_id', $patientId)
                    ->set('last_visit', date('Y-m-d H:i:s'))
                    ->update();
    }

    /**
     * Get patient statistics
     */
    public function getPatientStats()
    {
        $stats = [];
        
        $stats['total'] = $this->countAll();
        $stats['active'] = $this->where('status', 'Active')->countAllResults();
        $stats['inactive'] = $this->where('status', 'Inactive')->countAllResults();
        $stats['inpatient'] = $this->where('patient_type', 'Inpatient')->countAllResults();
        $stats['outpatient'] = $this->where('patient_type', 'Outpatient')->countAllResults();
        $stats['emergency'] = $this->where('patient_type', 'Emergency')->countAllResults();
        
        return $stats;
    }
}
