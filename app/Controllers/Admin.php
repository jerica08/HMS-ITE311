<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PatientModel;
use App\Models\StaffModel;
use App\Services\UserService;

class Admin extends BaseController
{
    protected $userModel;
    protected $userService;
    protected $patientModel;
    protected $staffModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userService = new UserService();
        $this->patientModel = new PatientModel();
        $this->staffModel = new StaffModel();
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
        
        // Get user statistics for dashboard
        $userStats = $this->userService->getUserStats();
        
        // Get patient statistics
        $patientStats = $this->getPatientStats();

        // Get staff statistics
        $staffStats = $this->getStaffStats();

        $data = [
            'currentUser' => $currentUser,
            'userStats' => $userStats['data'] ?? [
                'total_users' => 0,
                'active_users' => 0,
                'inactive_users' => 0,
                'admin_users' => 0
            ],
            'patientStats' => $patientStats,
            'staffStats' => $staffStats
        ];
        
        return view('admin/dashboard/index', $data);
    }

    /**
     * Get patient statistics for admin dashboard
     */
    private function getPatientStats()
    {
        try {
            $db = db_connect();
            $today = date('Y-m-d');

            return [
                'total_patients' => $db->query("SELECT COUNT(*) as count FROM patients")->getRow()->count,
                'active_patients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE status = 'Active'")->getRow()->count,
                'registrations_today' => $db->query("SELECT COUNT(*) as count FROM patients WHERE DATE(created_at) = ?", [$today])->getRow()->count,
                'outpatients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE patient_type = 'Outpatient'")->getRow()->count,
                'inpatients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE patient_type = 'Inpatient'")->getRow()->count,
                'emergency_patients' => $db->query("SELECT COUNT(*) as count FROM patients WHERE patient_type = 'Emergency'")->getRow()->count
            ];
        } catch (\Exception $e) {
            log_message('error', "Error getting patient statistics: " . $e->getMessage());
            return [
                'total_patients' => 0,
                'active_patients' => 0,
                'registrations_today' => 0,
                'outpatients' => 0,
                'inpatients' => 0,
                'emergency_patients' => 0
            ];
        }
    }

    /**
     * Get staff statistics for admin dashboard
     */
    private function getStaffStats()
    {
        try {
            $db = db_connect();

            return [
                'total_staff' => $db->query("SELECT COUNT(*) as count FROM staff")->getRow()->count,
            ];
        } catch (\Exception $e) {
            log_message('error', "Error getting staff statistics: " . $e->getMessage());
            return [
                'total_staff' => 0,
            ];
        }
    }

    // System Settings method
    

    // Audit Logs method
   

    

    public function staff(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $staffStats = $this->getStaffStats();
        $data = [
            'title' => 'Staff Management',
            'currentUser' => $currentUser,
            'staffStats' => $staffStats
        ];

        return view('admin/staff_management/index', $data);
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

    public function getPatientStatistics()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $patientStats = $this->getPatientStats();
        return $this->response->setJSON($patientStats);
    }
}
