<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Services\UserService;

class UserManagementController extends AdminBaseController 
{
    protected $userModel;
    protected $userService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userService = new UserService();
    }

    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        try {
            $db = \Config\Database::connect();

            if (!$db->tableExists('users')) {
                throw new \Exception('Users table does not exist. Please run database migrations.');
            }

            $search = $this->request->getGet('search') ?? '';
            $roleFilter = $this->request->getGet('role') ?? '';
            $statusFilter = $this->request->getGet('status') ?? '';

            // Get statuses and all users
            $statuses = $this->userModel->getDistinctStatuses();
            $allUsers = $this->userModel->findAll();

            // Filtering logic
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

            // Statistics
            $totalUsers = count($allUsers);
            $activeUsers = count(array_filter($allUsers, fn($u) => ($u['status'] ?? '') === 'active'));
            $inactiveUsers = count(array_filter($allUsers, fn($u) => ($u['status'] ?? '') === 'inactive'));
            $adminUsers = count(array_filter($allUsers, fn($u) => ($u['role'] ?? '') === 'admin'));

            $data = array_merge($this->getCommonViewData(), [
                'users' => array_values($filteredUsers),
                'pager' => null,
                'search' => $search,
                'roleFilter' => $roleFilter,
                'statusFilter' => $statusFilter,
                'statuses' => $statuses,
                'title' => 'User Management',
                'stats' => [
                    'total_users' => $totalUsers,
                    'active_users' => $activeUsers,
                    'inactive_users' => $inactiveUsers,
                    'admin_users' => $adminUsers
                ]
            ]);

            return view('admin/user_management/users', $data);

        } catch (\Exception $e) {
            log_message('error', 'Database error in UserManagementController::index(): ' . $e->getMessage());

            $data = array_merge($this->getCommonViewData(), [
                'users' => [],
                'pager' => null,
                'search' => '',
                'roleFilter' => '',
                'statusFilter' => '',
                'statuses' => [],
                'title' => 'User Management',
                'stats' => [
                    'total_users' => 0,
                    'active_users' => 0,
                    'inactive_users' => 0,
                    'admin_users' => 0
                ],
                'error' => 'Database error: ' . $e->getMessage()
            ]);

            return view('admin/user_management/users', $data);
        }
    }

    public function create()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $data = $this->request->getJSON(true);
        $result = $this->userService->createUser($data);
        
        return $this->response->setJSON($result);
    }

    public function edit($userId)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $result = $this->userService->getUserById($userId);
        return $this->response->setJSON($result);
    }

    public function update($userId)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        if ($this->request->getMethod() !== 'PUT' && $this->request->getMethod() !== 'POST') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $data = $this->request->getJSON(true);
        $result = $this->userService->updateUser($userId, $data);
        
        return $this->response->setJSON($result);
    }

    public function delete($userId)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        if ($this->request->getMethod() !== 'DELETE') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $currentUserId = session()->get('user_id');
        $result = $this->userService->deleteUser($userId, $currentUserId);
        
        return $this->response->setJSON($result);
    }

    public function resetPassword($userId)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        if ($this->request->getMethod() !== 'POST') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
        }

        $result = $this->userService->resetPassword($userId);
        return $this->response->setJSON($result);
    }

    public function api()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $search = $this->request->getGet('search') ?? '';
        $roleFilter = $this->request->getGet('role') ?? '';
        $statusFilter = $this->request->getGet('status') ?? '';

        $result = $this->userService->getAllUsers($search, $roleFilter, $statusFilter);
        return $this->response->setJSON($result);
    }

    public function statistics()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $result = $this->userService->getUserStats();
        return $this->response->setJSON($result);
    }
}
