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
        'role_id',
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
        'role_id'      => 'permit_empty|is_natural_no_zero',
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

        // Auto-generate employee_id if empty
        if (empty($data['data']['employee_id'])) {
            // Determine role name from role_id for prefix mapping
            $roleId = $data['data']['role_id'] ?? null;
            $roleName = null;
            if (!empty($roleId)) {
                $roleName = $this->getRoleNameById((int) $roleId);
            }
            $data['data']['employee_id'] = $this->generateEmployeeId($roleName);
        }

        return $data;
    }

    /**
     * Generate a unique employee ID based on role prefix.
     * Pattern: PREFIX + zero-padded sequence, e.g., DOC001
     */
    public function generateEmployeeId(?string $roleName): string
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

        // Normalize by expected keys. If we received role_name from the roles table,
        // map common names to the expected keys above.
        $key = null;
        if ($roleName) {
            $rn = strtolower(trim($roleName));
            // Map human names from role table to our keys
            $mapFromName = [
                'hospital administrator' => 'admin',
                'doctor' => 'doctor',
                'nurse' => 'nurse',
                'receptionist' => 'receptionist',
                'laboratory staff' => 'laboratorist',
                'pharmacist' => 'pharmacist',
                'accountant' => 'accountant',
                'it staff' => 'it_staff',
            ];
            $key = $mapFromName[$rn] ?? null;
        }

        $prefix = $key ? ($prefixMap[$key] ?? 'EMP') : 'EMP';

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

    /**
     * Get total staff count
     */
    public function getTotalStaff()
    {
        return $this->countAll();
    }

    /**
     * Fetch role_name by role_id from the role table
     */
    protected function getRoleNameById(int $roleId): ?string
    {
        $row = $this->db->table('role')
            ->select('role_name')
            ->where('role_id', $roleId)
            ->get()
            ->getRowArray();
        return $row['role_name'] ?? null;
    }
}
