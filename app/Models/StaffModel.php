<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'employee_id', 'first_name', 'middle_name', 'last_name', 'position',
        'department', 'phone', 'email', 'hire_date', 'status',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'first_name' => 'required|max_length[100]',
        'last_name'  => 'required|max_length[100]',
        'email'      => 'permit_empty|valid_email',
        'phone'      => 'permit_empty|max_length[20]',
        'status'     => 'in_list[active,inactive]'
    ];
}
