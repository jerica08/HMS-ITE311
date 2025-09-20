<?php

namespace App\Models;

use CodeIgniter\Model;

class ShiftModel extends Model
{
    protected $table = 'shifts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'staff_id',
        'date',
        'shift_type',
        'start_time',
        'end_time',
        'department',
        'notes',
        'repeat_weekly',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'staff_id'     => 'required|is_natural_no_zero',
        'date'         => 'required|valid_date',
        'shift_type'   => 'required|in_list[morning,afternoon,night,custom]',
        'start_time'   => 'required',
        'end_time'     => 'required',
        'department'   => 'required|max_length[100]',
        'notes'        => 'permit_empty',
        'repeat_weekly'=> 'permit_empty|in_list[0,1]'
    ];
}
