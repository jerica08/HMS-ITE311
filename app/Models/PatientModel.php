<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'full_name',
        'age',
        'gender',
        'phone',
        'primary_condition',
        'room',
        'status',
        'patient_type',
        'last_visit',
        'notes',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'full_name' => 'required|max_length[191]',
        'age' => 'permit_empty|integer|greater_than_equal_to[0]|less_than_equal_to[120]',
        'gender' => 'permit_empty|in_list[male,female,other]',
        'phone' => 'permit_empty|max_length[32]',
        'primary_condition' => 'permit_empty|max_length[191]',
        'room' => 'permit_empty|max_length[50]',
        'status' => 'permit_empty|in_list[stable,critical,admitted,discharged,emergency]',
        'patient_type' => 'permit_empty|in_list[outpatient,inpatient]',
        'last_visit' => 'permit_empty|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}


