<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Services\UserService;

class Admin extends BaseController
{
    protected $userModel;
    protected $userService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userService = new UserService();
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

        return view('admin/dashboard/index');
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

            // Calculate statistics
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

    // New analytics method
    public function analytics()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch analytics data if needed
        return view('admin/analytics and reports/analytics');
    }

    // System Settings method
    public function systemSettings()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch current system settings from database
        $data = [
            'title' => 'System Settings'
        ];

        return view('admin/system-setting/system_settings', $data);
    }

    // Audit Logs method
    public function auditLogs()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch audit logs from database
        $data = [
            'title' => 'Audit Logs'
        ];

        return view('admin/audit/audit_logs', $data);
    }

    // Financial Management method
    public function financial()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch financial data from database
        $data = [
            'title' => 'Financial Management'
        ];

        return view('admin/financial/financial_management', $data);
    }

    public function resource(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch resource data from database
        $data = [
            'title' => 'Resource Management'
        ];

        return view('admin/resource/resource_management', $data);
    }

    public function securityAccess(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch security data from database
        $data = [
            'title' => 'Security & Access'
        ];

        return view('admin/security-access/security_access', $data);
    }

    public function patient(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch patient data from database
        $data = [
            'title' => 'Patient Management'
        ];

        return view('admin/patient/patient_management', $data);
    }

    public function communication(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch communication data from database
        $data = [
            'title' => 'Communication & Notifications'
        ];

        return view('admin/communication(empty)/communication', $data);
    }

    public function staff(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // You can add logic here to fetch staff data from database
        $data = [
            'title' => 'Staff Management'
        ];

        return view('admin/staff-management/staff_management', $data);
    }

    // Placeholder methods for reports
    public function reports()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic for reports overview page
        return view('admin/reports/overview');
    }

    public function generateReport()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to generate a custom report
        // Placeholder: return JSON or view
        return $this->response->setJSON(['status' => 'success', 'message' => 'Report generated']);
    }

    public function exportReport()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to export report as PDF or Excel
        // Placeholder: return JSON or file download
        return $this->response->setJSON(['status' => 'success', 'message' => 'Report exported']);
    }

    public function scheduleReport()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to show schedule report form
        return view('admin/reports/schedule');
    }

    public function storeScheduledReport()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to store scheduled report
        return $this->response->setJSON(['status' => 'success', 'message' => 'Scheduled report saved']);
    }

    public function getAnalyticsData()
    {
        // This method has been removed as per user request.
    }

    public function getReportMetrics()
    {
        // This method has been removed as per user request.
    }

    // User CRUD Methods
    public function createUser()
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

    public function editUser($userId)
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $result = $this->userService->getUserById($userId);
        return $this->response->setJSON($result);
    }

    public function updateUser($userId)
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

    public function deleteUser($userId)
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

    // API Methods for AJAX calls
    public function getUsersApi()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $search = $this->request->getGet('search') ?? '';
        $roleFilter = $this->request->getGet('role') ?? '';
        $statusFilter = $this->request->getGet('status') ?? '';

        $result = $this->userService->getAllUsers($search, $roleFilter, $statusFilter);
        return $this->response->setJSON($result);
    }

    public function getUserStatistics()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $result = $this->userService->getUserStats();
        return $this->response->setJSON($result);
    }
}
