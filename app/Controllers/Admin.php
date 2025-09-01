<?php

namespace App\Controllers;

use App\Models\UserModel;

class Admin extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    private function checkAdminAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Admins only.');
        }
        return null;
    }

    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        return view('admin/dashboard');
    }
    
    public function users()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;
        
        try {
            // Check if users table exists and get basic data
            $db = \Config\Database::connect();
            
            if (!$db->tableExists('users')) {
                throw new \Exception('Users table does not exist. Please run database migrations.');
            }
            
            $search = $this->request->getGet('search') ?? '';
            $roleFilter = $this->request->getGet('role') ?? '';
            $statusFilter = $this->request->getGet('status') ?? '';
            
            // Get all users first (simpler approach)
            $allUsers = $this->userModel->findAll();
            
            // Filter users in PHP if needed
            $filteredUsers = $allUsers;
            
            if (!empty($search)) {
                $filteredUsers = array_filter($filteredUsers, function($user) use ($search) {
                    return stripos($user['username'] ?? '', $search) !== false ||
                           stripos($user['email'] ?? '', $search) !== false ||
                           stripos($user['first_name'] ?? '', $search) !== false ||
                           stripos($user['last_name'] ?? '', $search) !== false;
                });
            }
            
            if (!empty($roleFilter)) {
                $filteredUsers = array_filter($filteredUsers, function($user) use ($roleFilter) {
                    return ($user['role'] ?? '') === $roleFilter;
                });
            }
            
            if (!empty($statusFilter)) {
                $filteredUsers = array_filter($filteredUsers, function($user) use ($statusFilter) {
                    return ($user['status'] ?? '') === $statusFilter;
                });
            }
            
            // Calculate statistics
            $totalUsers = count($allUsers);
            $activeUsers = count(array_filter($allUsers, function($user) {
                return ($user['status'] ?? '') === 'active';
            }));
            $inactiveUsers = count(array_filter($allUsers, function($user) {
                return ($user['status'] ?? '') === 'inactive';
            }));
            $adminUsers = count(array_filter($allUsers, function($user) {
                return ($user['role'] ?? '') === 'admin';
            }));
            
            $data = [
                'users' => array_values($filteredUsers), // Reset array keys
                'pager' => null, // Disable pagination for now
                'search' => $search,
                'roleFilter' => $roleFilter,
                'statusFilter' => $statusFilter,
                'title' => 'User Management',
                'stats' => [
                    'total_users' => $totalUsers,
                    'active_users' => $activeUsers,
                    'inactive_users' => $inactiveUsers,
                    'admin_users' => $adminUsers
                ]
            ];
            
            return view('admin/user_management/users', $data);
            
        } catch (\Exception $e) {
            // Log the specific error for debugging
            log_message('error', 'Database error in Admin::users(): ' . $e->getMessage());
            
            // Return with empty data and error message
            $data = [
                'users' => [],
                'pager' => null,
                'search' => '',
                'roleFilter' => '',
                'statusFilter' => '',
                'title' => 'User Management',
                'stats' => [
                    'total_users' => 0,
                    'active_users' => 0,
                    'inactive_users' => 0,
                    'admin_users' => 0
                ],
                'error' => 'Database error: ' . $e->getMessage()
            ];
            
            return view('admin/user_management/users', $data);
        }
    }
}
