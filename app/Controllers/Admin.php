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
