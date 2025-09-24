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
}
