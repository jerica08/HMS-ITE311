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
        'patient_uid',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'department',
        'room',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'patient_uid' => 'required|min_length[4]|max_length[32]',
        'first_name' => 'required|max_length[100]',
        'last_name'  => 'required|max_length[100]',
        'email'      => 'permit_empty|valid_email|max_length[191]',
        'phone'      => 'permit_empty|max_length[32]',
        'gender'     => 'permit_empty|in_list[male,female,other]',
        'status'     => 'permit_empty|in_list[admitted,discharged,critical,stable,emergency]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}


