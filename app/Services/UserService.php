<?php

namespace App\Services;

use App\Models\UserModel;
use App\Models\StaffModel;

class UserService
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Create a new user (staff-linked)
     */
    public function createUser(array $data): array
    {
        log_message('info', 'UserService::createUser called with data: ' . json_encode($data));

        // 1) Try to enrich from staff
        $staffModel = new StaffModel();
        $staff = null;
        try {
            $db = \Config\Database::connect();
            $hasStatus = $db->fieldExists('status', 'staff');

            if (!empty($data['staff_id'])) {
                $builder = $staffModel->where('staff_id', (int)$data['staff_id']);
                if ($hasStatus) { $builder = $builder->where('status', 'active'); }
                $staff = $builder->first();
            }
            if (!$staff && !empty($data['employee_id'])) {
                $builder = $staffModel->where('employee_id', $data['employee_id']);
                if ($hasStatus) { $builder = $builder->where('status', 'active'); }
                $staff = $builder->first();
            }
            if (!$staff && !empty($data['email'])) {
                $builder = $staffModel->where('email', $data['email']);
                if ($hasStatus) { $builder = $builder->where('status', 'active'); }
                $staff = $builder->first();
            }
        } catch (\Exception $e) {
            log_message('error', 'Error checking staff linkage: ' . $e->getMessage());
        }

        if ($staff) {
            $data['first_name'] = $data['first_name'] ?? ($staff['first_name'] ?? null);
            $data['last_name']  = $data['last_name']  ?? ($staff['last_name'] ?? null);
            $data['email']      = $data['email']      ?? ($staff['email'] ?? null);
            $data['employee_id']= $data['employee_id'] ?? ($staff['employee_id'] ?? null);
            $data['department'] = $data['department'] ?? ($staff['department'] ?? null);
            $data['role']       = $data['role'] ?? ($staff['role'] ?? null);
        }

        // 2) Validate
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email',
            'role' => 'required|in_list[admin,doctor,nurse,receptionist,laboratorist,pharmacist,accountant,it_staff]',
            'phone' => 'permit_empty|min_length[10]|max_length[15]',
            'department' => 'permit_empty|max_length[100]',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->run($data)) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validation->getErrors()
            ];
        }

        try {
            // 3) Username: use provided if unique; else generate from name
            $username = trim($data['username'] ?? '');
            if ($username !== '') {
                if ($this->userModel->where('username', $username)->first()) {
                    $base = $username;
                    $i = 1;
                    while ($this->userModel->where('username', $username)->first()) {
                        $username = $base . $i;
                        $i++;
                    }
                }
            } else {
                $baseUsername = strtolower(($data['first_name'] ?? 'user') . '.' . ($data['last_name'] ?? 'account'));
                $username = $baseUsername;
                $counter = 1;
                while ($this->userModel->where('username', $username)->first()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }
            }

            $password = $data['password'];

            // Detect columns that actually exist in the users table to avoid unknown column errors
            $db = \Config\Database::connect();
            $hasPhone       = $db->fieldExists('phone', 'users');
            $hasDepartment  = $db->fieldExists('department', 'users');
            $hasEmployeeId  = $db->fieldExists('employee_id', 'users');
            $hasStatus      = $db->fieldExists('status', 'users');
            $hasCreatedAt   = $db->fieldExists('created_at', 'users');
            $hasUpdatedAt   = $db->fieldExists('updated_at', 'users');

            $userData = [
                'username'   => $username,
                'email'      => $data['email'],
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'role'       => $data['role'],
            ];
            if ($hasPhone) {
                $userData['phone'] = $data['phone'] ?? null;
            }
            if ($hasDepartment) {
                $userData['department'] = $data['department'] ?? null;
            }
            if ($hasStatus) {
                $userData['status'] = 'active';
            }
            if ($hasCreatedAt) {
                $userData['created_at'] = date('Y-m-d H:i:s');
            }
            if ($hasUpdatedAt) {
                $userData['updated_at'] = date('Y-m-d H:i:s');
            }

            if ($hasEmployeeId) {
                if ($staff && !empty($staff['employee_id'])) {
                    $userData['employee_id'] = $staff['employee_id'];
                } elseif (!empty($data['employee_id'])) {
                    $userData['employee_id'] = $data['employee_id'];
                }
            }

            // 4) Insert
            // Include staff_id when possible to satisfy FK constraints
            $hasStaffId = $db->fieldExists('staff_id', 'users');
            if ($hasStaffId) {
                if (!empty($data['staff_id'])) {
                    $userData['staff_id'] = (int) $data['staff_id'];
                } elseif (!empty($staff['staff_id'])) {
                    $userData['staff_id'] = (int) $staff['staff_id'];
                }
            }

            $builder = $db->table('users');
            $result = $builder->insert($userData);

            if ($result) {
                $userId = $db->insertID();
                log_message('info', 'User created successfully with ID: ' . $userId);
                return [
                    'status' => 'success',
                    'message' => 'User created successfully',
                    'user_id' => $userId
                ];
            } else {
                $error = $db->error();
                log_message('error', 'Database insert failed. Error: ' . json_encode($error));
                return [
                    'status' => 'error',
                    'message' => 'Failed to create user - Database error: ' . ($error['message'] ?? 'Unknown error')
                ];
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in createUser: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return [
                'status' => 'error',
                'message' => 'Database error occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get user by ID
     */
    public function getUserById(int $userId): array
    {
        try {
            $user = $this->userModel->find($userId);
            
            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found'
                ];
            }

            return [
                'status' => 'success',
                'data' => $user
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error fetching user: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Update user data
     */
    public function updateUser(int $userId, array $data): array
    {
        try {
            log_message('info', 'UserService::updateUser called with userId: ' . $userId . ', data: ' . json_encode($data));

            $user = $this->userModel->find($userId);
            if (!$user) {
                log_message('error', 'User not found with ID: ' . $userId);
                return [
                    'status' => 'error',
                    'message' => 'User not found'
                ];
            }

            log_message('info', 'Found user: ' . json_encode($user));

            // Start with minimal update data - only fields that definitely exist
            $updateData = [];

            // Only update basic fields that should exist in any users table
            if (isset($data['first_name']) && !empty(trim($data['first_name']))) {
                $updateData['first_name'] = trim($data['first_name']);
            }
            if (isset($data['last_name']) && !empty(trim($data['last_name']))) {
                $updateData['last_name'] = trim($data['last_name']);
            }
            if (isset($data['email']) && !empty(trim($data['email']))) {
                $updateData['email'] = trim($data['email']);
            }
            if (isset($data['role']) && !empty(trim($data['role']))) {
                $updateData['role'] = trim($data['role']);
            }

            log_message('info', 'Minimal update data: ' . json_encode($updateData));

            // Check if there's actually data to update
            if (empty($updateData)) {
                log_message('warning', 'No valid data to update for user ID: ' . $userId);
                return [
                    'status' => 'error',
                    'message' => 'No valid data provided for update'
                ];
            }

            // Basic validation
            if (isset($updateData['email']) && !filter_var($updateData['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'status' => 'error',
                    'message' => 'Please enter a valid email address'
                ];
            }

            // Check email uniqueness if provided
            if (isset($updateData['email'])) {
                $existingUser = $this->userModel->where('email', $updateData['email'])
                                                ->where('id !=', $userId)
                                                ->first();
                if ($existingUser) {
                    return [
                        'status' => 'error',
                        'message' => 'Email already exists'
                    ];
                }
            }

            log_message('info', 'Attempting to update user with minimal data: ' . json_encode($updateData));
            
            // Try direct database update to bypass model validation issues
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $result = $builder->where('id', $userId)->update($updateData);
            
            log_message('info', 'Direct DB update result: ' . ($result ? 'success' : 'failed'));

            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'User updated successfully'
                ];
            } else {
                // Get last database error
                $error = $db->error();
                log_message('error', 'Database update failed. Error: ' . json_encode($error));

                return [
                    'status' => 'error',
                    'message' => 'Failed to update user - Database error: ' . ($error['message'] ?? 'Unknown error')
                ];
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception in updateUser: ' . $e->getMessage() . ' | Trace: ' . $e->getTraceAsString());
            return [
                'status' => 'error',
                'message' => 'Database error occurred: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete user
     */
    public function deleteUser(int $userId, int $currentUserId): array
    {
        try {
            // Prevent self-deletion
            if ($userId == $currentUserId) {
                return [
                    'status' => 'error',
                    'message' => 'Cannot delete your own account'
                ];
            }

            $user = $this->userModel->find($userId);
            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found'
                ];
            }

            $result = $this->userModel->delete($userId);
            
            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'User deleted successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to delete user'
                ];
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting user: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(int $userId): array
    {
        try {
            $user = $this->userModel->find($userId);
            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'User not found'
                ];
            }

            // Generate new temporary password
            $tempPassword = bin2hex(random_bytes(4)); // 8 character temp password
            
            $updateData = [
                'password' => password_hash($tempPassword, PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->userModel->update($userId, $updateData);
            
            if ($result) {
                return [
                    'status' => 'success',
                    'message' => 'Password reset successfully',
                    'temp_password' => $tempPassword
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to reset password'
                ];
            }
        } catch (\Exception $e) {
            log_message('error', 'Error resetting password: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Get all users with filtering
     */
    public function getAllUsers(string $search = '', string $roleFilter = '', string $statusFilter = ''): array
    {
        try {
            // Get all users first
            $allUsers = $this->userModel->findAll();

            // Filter users in PHP if needed
            $filteredUsers = $allUsers;

            if (!empty($search)) {
                $filteredUsers = array_filter($filteredUsers, function ($user) use ($search) {
                    return stripos($user['username'] ?? '', $search) !== false ||
                        stripos($user['email'] ?? '', $search) !== false ||
                        stripos($user['first_name'] ?? '', $search) !== false ||
                        stripos($user['last_name'] ?? '', $search) !== false;
                });
            }

            if (!empty($roleFilter)) {
                $filteredUsers = array_filter($filteredUsers, function ($user) use ($roleFilter) {
                    return ($user['role'] ?? '') === $roleFilter;
                });
            }

            if (!empty($statusFilter)) {
                $filteredUsers = array_filter($filteredUsers, function ($user) use ($statusFilter) {
                    return ($user['status'] ?? '') === $statusFilter;
                });
            }

            return [
                'status' => 'success',
                'data' => array_values($filteredUsers) // Reset array keys
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error fetching users: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database error occurred'
            ];
        }
    }

    /**
     * Get user statistics
     */
    public function getUserStats(): array
    {
        try {
            $allUsers = $this->userModel->findAll();

            $totalUsers = count($allUsers);
            $activeUsers = count(array_filter($allUsers, function ($user) {
                return ($user['status'] ?? '') === 'active';
            }));
            $inactiveUsers = count(array_filter($allUsers, function ($user) {
                return ($user['status'] ?? '') === 'inactive';
            }));
            $adminUsers = count(array_filter($allUsers, function ($user) {
                return ($user['role'] ?? '') === 'admin';
            }));

            return [
                'status' => 'success',
                'data' => [
                    'total_users' => $totalUsers,
                    'active_users' => $activeUsers,
                    'inactive_users' => $inactiveUsers,
                    'admin_users' => $adminUsers
                ]
            ];
        } catch (\Exception $e) {
            log_message('error', 'Error fetching user stats: ' . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Database error occurred'
            ];
        }
    }
}
