<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Services\UserService;
use App\Models\StaffModel;

class UserManagementController extends AdminBaseController 
{
    protected $userModel;
    protected $userService;
    protected $staffModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userService = new UserService();
        $this->staffModel = new StaffModel();
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

            // Get filters from query params
            $search       = $this->request->getGet('search') ?? '';
            $roleFilter   = $this->request->getGet('role') ?? '';
            $statusFilter = $this->request->getGet('status') ?? '';

            // Build query dynamically
            $builder = $this->userModel->builder();

            if (!empty($search)) {
                $builder->groupStart()
                        ->like('username', $search)
                        ->orLike('email', $search)
                        ->orLike('first_name', $search)
                        ->orLike('last_name', $search)
                        ->orLike('employee_id', $search)
                        ->groupEnd();
            }

            if (!empty($roleFilter)) {
                $builder->where('role', $roleFilter);
            }

            if (!empty($statusFilter)) {
                $builder->where('status', $statusFilter);
            }

            // Get filtered users
            $users = $builder->get()->getResultArray();

            // Stats (always calculated from all users)
            $allUsers     = $this->userModel->findAll();
            $totalUsers   = count($allUsers);
            $activeUsers  = count(array_filter($allUsers, fn($u) => ($u['status'] ?? '') === 'active'));
            $inactiveUsers= count(array_filter($allUsers, fn($u) => ($u['status'] ?? '') === 'inactive'));
            $adminUsers   = count(array_filter($allUsers, fn($u) => ($u['role'] ?? '') === 'admin'));

            $data = array_merge($this->getCommonViewData(), [
                'users'        => $users,
                'pager'        => null,
                'search'       => $search,
                'roleFilter'   => $roleFilter,
                'statusFilter' => $statusFilter,
                'statuses'     => $this->userModel->getDistinctStatuses(),
                'title'        => 'User Management',
                'stats'        => [
                    'total_users'   => $totalUsers,
                    'active_users'  => $activeUsers,
                    'inactive_users'=> $inactiveUsers,
                    'admin_users'   => $adminUsers
                ]
            ]);

            return view('admin/user_management/users', $data);

        } catch (\Exception $e) {
            log_message('error', 'Database error in UserManagementController::index(): ' . $e->getMessage());

            $data = array_merge($this->getCommonViewData(), [
                'users'        => [],
                'pager'        => null,
                'search'       => '',
                'roleFilter'   => '',
                'statusFilter' => '',
                'statuses'     => [],
                'title'        => 'User Management',
                'stats'        => [
                    'total_users'   => 0,
                    'active_users'  => 0,
                    'inactive_users'=> 0,
                    'admin_users'   => 0
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

        $data = $this->request->getPost();
            if (empty($data)) {
                // fallback for JSON requests
                $data = $this->request->getJSON(true);
            }
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

    /**
     * API: Return staff members who do not yet have user accounts
     * Matching is done by employee_id or email to ensure robust linking
     */
    public function staffWithoutAccounts()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        try {
            $db = \Config\Database::connect();

            // Some environments have strict SQL modes that struggle with NOT EXISTS raw clauses.
            // Use a LEFT JOIN approach to find staff rows that have no matching user by employee_id or email.
            // Fallback approach for maximum compatibility: fetch active staff then filter in PHP
            $staffModel = new \App\Models\StaffModel();
            $userModel  = new \App\Models\UserModel();

            // Only filter by status if the column exists
            $staffBuilder = $staffModel->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC');
            if ($db->fieldExists('status', 'staff')) {
                $staffBuilder = $staffBuilder->where('status', 'active');
            }
            $allActiveStaff = $staffBuilder->findAll();

            $staff = [];
            $usersHasEmployeeId = $db->fieldExists('employee_id', 'users');
            $usersHasEmail      = $db->fieldExists('email', 'users');

            foreach ($allActiveStaff as $s) {
                $employeeId = $s['employee_id'] ?? null;
                $email      = $s['email'] ?? null;

                $hasUser = false;
                if ($usersHasEmployeeId && !empty($employeeId)) {
                    $hasUser = (bool) $userModel->where('employee_id', $employeeId)->first();
                }
                if (!$hasUser && $usersHasEmail && !empty($email)) {
                    $hasUser = (bool) $userModel->where('email', $email)->first();
                }

                if (!$hasUser) {
                    $staff[] = [
                        'id' => $s['staff_id'] ?? ($s['id'] ?? null),
                        'first_name' => $s['first_name'] ?? null,
                        'last_name' => $s['last_name'] ?? null,
                        'email' => $s['email'] ?? null,
                        'phone' => $s['contact_no'] ?? ($s['phone'] ?? null),
                        'department' => $s['department'] ?? null,
                        'role' => $s['role'] ?? null,
                        'employee_id' => $s['employee_id'] ?? null,
                    ];
                }
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $staff,
            ]);
        } catch (\Exception $e) {
            // Do not block user creation flow; return empty list on error
            log_message('error', 'Error fetching staff without accounts: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'success',
                'data' => [],
                'warning' => 'Staff list unavailable: ' . $e->getMessage(),
            ]);
        }
    }
}
