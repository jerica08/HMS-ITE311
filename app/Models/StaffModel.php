<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'role',
        'employee_id',
        'status',
        'hire_date',
        'notes',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Auto hooks
    protected $beforeInsert = ['setDefaults'];

    protected $validationRules = [
        'first_name'   => 'required|max_length[100]',
        'last_name'    => 'required|max_length[100]',
        'email'        => 'required|valid_email|is_unique[staff.email,id,{id}]',
        'phone'        => 'permit_empty|max_length[20]',
        'department'   => 'permit_empty|max_length[100]',
        'role'         => 'permit_empty|in_list[admin,doctor,nurse,pharmacist,receptionist,laboratorist,it_staff,accountant]',
        'employee_id'  => 'permit_empty|max_length[50]|is_unique[staff.employee_id,id,{id}]',
        'status'       => 'permit_empty|in_list[active,inactive,suspended]',
        'hire_date'    => 'permit_empty|valid_date',
        'notes'        => 'permit_empty',
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

        // Default status
        if (empty($data['data']['status'])) {
            $data['data']['status'] = 'active';
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
