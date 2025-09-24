<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'email', 'password', 'role', 'first_name', 'last_name', 
        'phone', 'department', 'employee_id', 'status', 'hire_date',
        'read_access', 'write_access', 'delete_access', 'admin_access'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Validation rules
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,doctor,nurse,receptionist,pharmacist,accountant,it_staff,laboratorist]',
        'first_name' => 'required|max_length[100]',
        'last_name' => 'required|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'department' => 'permit_empty|max_length[100]',
        'employee_id' => 'permit_empty|max_length[50]',
        'status' => 'required|in_list[active,inactive]'
    ];
    
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'min_length' => 'Username must be at least 3 characters',
            'is_unique' => 'Username already exists'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email',
            'is_unique' => 'Email already exists'
        ],
        'password' => [
            'required' => 'Password is required',
            'min_length' => 'Password must be at least 6 characters'
        ]
    ];
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    
    // Get users with pagination and search
    public function getUsersWithPagination($perPage = 10, $search = '')
    {
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('username', $search)
                    ->orLike('email', $search)
                    ->orLike('first_name', $search)
                    ->orLike('last_name', $search)
                    ->orLike('role', $search)
                    ->groupEnd();
        }
        
        return $builder->orderBy('created_at', 'DESC')->paginate($perPage);
    }
    
    // Get user count by role
    public function getUserCountByRole()
    {
        return $this->select('role, COUNT(*) as count')
                    ->groupBy('role')
                    ->findAll();
    }
    
    // Get active users count
    public function getActiveUsersCount()
    {
        return $this->where('status', 'active')->countAllResults();
    }
    
    // Toggle user status
    public function toggleStatus($id)
    {
        $user = $this->find($id);
        if ($user) {
            $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
            return $this->update($id, ['status' => $newStatus]);
        }
        return false;
    }
    
    // Reset user password
    public function resetUserPassword($id, $newPassword)
    {
        return $this->update($id, ['password' => $newPassword]);
    }
}