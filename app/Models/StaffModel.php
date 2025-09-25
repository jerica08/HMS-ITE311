<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'employee_id',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'contact_no',
        'email',
        'address',
        'department',
        'designation',
        'role',
        'date_joined',
    ];

    // No created_at/updated_at columns on staff table by default
    protected $useTimestamps = false;

    // Auto hooks
    protected $beforeInsert = ['setDefaults'];

    protected $validationRules = [
        'first_name'   => 'required|max_length[100]',
        'last_name'    => 'permit_empty|max_length[100]',
        'email'        => 'permit_empty|valid_email|is_unique[staff.email,staff_id,{staff_id}]',
        'contact_no'   => 'permit_empty|max_length[255]',
        'department'   => 'permit_empty|max_length[255]',
        'designation'  => 'permit_empty|max_length[255]',
        'role'         => 'permit_empty|in_list[admin,doctor,nurse,pharmacist,receptionist,laboratorist,it_staff,accountant]',
        'employee_id'  => 'permit_empty|max_length[255]|is_unique[staff.employee_id,staff_id,{staff_id}]',
        'date_joined'  => 'permit_empty|valid_date[Y-m-d]',
        'dob'          => 'permit_empty|valid_date[Y-m-d]',
        'gender'       => 'permit_empty|in_list[male,female,other]',
        'address'      => 'permit_empty',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email already exists for another staff member.'
        ],
        'employee_id' => [
            'is_unique' => 'Employee ID must be unique.'
        ],
    ];

    /**
     * Set default/derived fields before insert
     */
    protected function setDefaults(array $data)
    {
        if (!isset($data['data']) || !is_array($data['data'])) {
            return $data;
        }

        // Normalize role to lowercase if provided
        if (!empty($data['data']['role'])) {
            $data['data']['role'] = strtolower(trim($data['data']['role']));
        }

        // Auto-generate employee_id if empty
        if (empty($data['data']['employee_id'])) {
            $role = $data['data']['role'] ?? null;
            $data['data']['employee_id'] = $this->generateEmployeeId($role);
        }

        return $data;
    }

    /**
     * Generate a unique employee ID based on role prefix.
     * Pattern: PREFIX + zero-padded sequence, e.g., DOC001
     */
    public function generateEmployeeId(?string $role): string
    {
        $prefixMap = [
            'doctor' => 'DOC',
            'nurse' => 'NUR',
            'laboratorist' => 'LAB',
            'pharmacist' => 'PHR',
            'receptionist' => 'REC',
            'it_staff' => 'IT',
            'accountant' => 'ACC',
            'admin' => 'ADM',
        ];

        $prefix = $prefixMap[strtolower((string)$role)] ?? 'EMP';

        // Find the latest employee_id for this prefix
        $builder = $this->db->table($this->table);
        $row = $builder
            ->select('employee_id')
            ->like('employee_id', $prefix, 'after')
            ->orderBy('employee_id', 'DESC')
            ->get(1)
            ->getRowArray();

        $next = 1;
        if ($row && !empty($row['employee_id'])) {
            if (preg_match('/^[A-Z_]+(\d{1,})$/', $row['employee_id'], $m)) {
                $next = (int)$m[1] + 1;
            }
        }

        return $prefix . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
    }
}
