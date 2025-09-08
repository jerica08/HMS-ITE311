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

    private function getCurrentUserData()
    {
        helper('UserHelper');
        return \App\Helpers\UserHelper::getCurrentUser();
    }

    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('admin/dashboard/index', ['currentUser' => $currentUser]);
    }

    

    // New analytics method
    

    // System Settings method
    public function systemSettings()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'System Settings',
            'currentUser' => $currentUser
        ];

        return view('admin/system-setting/system_settings', $data);
    }

    // Audit Logs method
    public function auditLogs()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Audit Logs',
            'currentUser' => $currentUser
        ];

        return view('admin/audit/audit_logs', $data);
    }

    // Financial Management method
    public function financial()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Financial Management',
            'currentUser' => $currentUser
        ];

        return view('admin/financial/financial_management', $data);
    }

    

    public function securityAccess(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Security & Access',
            'currentUser' => $currentUser
        ];

        return view('admin/security-access/security_access', $data);
    }

    public function patient(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Patient Management',
            'currentUser' => $currentUser
        ];

        return view('admin/patient/patient_management', $data);
    }

    public function communication(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Communication & Notifications',
            'currentUser' => $currentUser
        ];

        return view('admin/communication/communication', $data);
    }

    public function staff(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Staff Management',
            'currentUser' => $currentUser
        ];

        return view('admin/staff-management/staff_management', $data);
    }

    // Placeholder methods for reports
    public function reports()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        return view('admin/reports/overview', ['currentUser' => $currentUser]);
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

        $currentUser = $this->getCurrentUserData();
        return view('admin/reports/schedule', ['currentUser' => $currentUser]);
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
