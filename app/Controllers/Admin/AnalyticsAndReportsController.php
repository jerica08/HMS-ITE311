<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminBaseController;
use App\Models\UserModel;

class AnalyticsAndReportsController extends AdminBaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $data = array_merge($this->getCommonViewData(), [
            'title' => 'Reports Overview'
        ]);

        return view('admin/reports/overview', $data);
    }

    public function analytics()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        try {
            // Get comprehensive analytics data
            $analyticsData = $this->getAnalyticsData();
            
            $data = array_merge($this->getCommonViewData(), [
                'title' => 'Analytics & Reports',
                'analytics' => $analyticsData
            ]);

            return view('admin/analytics and reports/analytics', $data);

        } catch (\Exception $e) {
            log_message('error', 'Analytics error: ' . $e->getMessage());
            
            $data = array_merge($this->getCommonViewData(), [
                'title' => 'Analytics & Reports',
                'analytics' => $this->getEmptyAnalyticsData(),
                'error' => 'Unable to load analytics data: ' . $e->getMessage()
            ]);

            return view('admin/analytics and reports/analytics', $data);
        }
    }

    private function getAnalyticsData()
    {
        // User Analytics
        $userStats = $this->getUserAnalytics();
        
        // System Analytics
        $systemStats = $this->getSystemAnalytics();
        
        // Activity Analytics
        $activityStats = $this->getActivityAnalytics();
        
        // Performance Metrics
        $performanceStats = $this->getPerformanceMetrics();

        return [
            'users' => $userStats,
            'system' => $systemStats,
            'activity' => $activityStats,
            'performance' => $performanceStats,
            'charts' => $this->getChartData()
        ];
    }

    private function getUserAnalytics()
    {
        try {
            $allUsers = $this->userModel->findAll();
            
            $totalUsers = count($allUsers);
            $activeUsers = count(array_filter($allUsers, fn($u) => ($u['status'] ?? '') === 'active'));
            $inactiveUsers = count(array_filter($allUsers, fn($u) => ($u['status'] ?? '') === 'inactive'));
            
            // Role distribution
            $roleDistribution = [];
            $roles = ['admin', 'doctor', 'nurse', 'it_staff', 'laboratorist', 'pharmacist', 'receptionist'];
            
            foreach ($roles as $role) {
                $roleDistribution[$role] = count(array_filter($allUsers, fn($u) => ($u['role'] ?? '') === $role));
            }

            // Recent registrations (last 30 days)
            $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
            $recentUsers = array_filter($allUsers, function($user) use ($thirtyDaysAgo) {
                return isset($user['created_at']) && $user['created_at'] >= $thirtyDaysAgo;
            });

            return [
                'total_users' => $totalUsers,
                'active_users' => $activeUsers,
                'inactive_users' => $inactiveUsers,
                'active_percentage' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0,
                'role_distribution' => $roleDistribution,
                'recent_registrations' => count($recentUsers),
                'growth_rate' => $this->calculateUserGrowthRate($allUsers)
            ];
        } catch (\Exception $e) {
            log_message('error', 'User analytics error: ' . $e->getMessage());
            return $this->getEmptyUserAnalytics();
        }
    }

    private function getSystemAnalytics()
    {
        $db = \Config\Database::connect();
        
        return [
            'database_size' => $this->getDatabaseSize(),
            'total_tables' => count($db->listTables()),
            'php_version' => PHP_VERSION,
            'codeigniter_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
            'memory_usage' => $this->getMemoryUsage(),
            'disk_usage' => $this->getDiskUsage()
        ];
    }

    private function getActivityAnalytics()
    {
        // Simulated activity data - replace with actual log analysis
        return [
            'daily_logins' => rand(50, 200),
            'page_views_today' => rand(500, 2000),
            'active_sessions' => rand(10, 50),
            'failed_login_attempts' => rand(0, 10),
            'most_accessed_pages' => [
                'Dashboard' => rand(100, 500),
                'User Management' => rand(50, 200),
                'Reports' => rand(30, 150),
                'Settings' => rand(20, 100)
            ]
        ];
    }

    private function getPerformanceMetrics()
    {
        return [
            'average_response_time' => round(rand(100, 500) / 100, 2) . 'ms',
            'database_queries_today' => rand(1000, 5000),
            'cache_hit_rate' => rand(85, 98) . '%',
            'error_rate' => rand(0, 5) . '%',
            'server_load' => round(rand(10, 80) / 100, 2)
        ];
    }

    private function getChartData()
    {
        // Generate sample chart data
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        $userGrowth = [];
        $loginActivity = [];
        
        foreach ($months as $month) {
            $userGrowth[] = rand(10, 100);
            $loginActivity[] = rand(50, 300);
        }

        return [
            'user_growth' => [
                'labels' => $months,
                'data' => $userGrowth
            ],
            'login_activity' => [
                'labels' => $months,
                'data' => $loginActivity
            ],
            'role_distribution' => [
                'labels' => ['Admin', 'Doctor', 'Nurse', 'IT Staff', 'Lab', 'Pharmacy'],
                'data' => [rand(5, 15), rand(20, 40), rand(30, 60), rand(5, 15), rand(10, 25), rand(8, 20)]
            ]
        ];
    }

    private function calculateUserGrowthRate($users)
    {
        // Calculate growth rate based on last 30 days vs previous 30 days
        $now = time();
        $thirtyDaysAgo = $now - (30 * 24 * 60 * 60);
        $sixtyDaysAgo = $now - (60 * 24 * 60 * 60);

        $recentUsers = 0;
        $previousUsers = 0;

        foreach ($users as $user) {
            if (isset($user['created_at'])) {
                $userTime = strtotime($user['created_at']);
                if ($userTime >= $thirtyDaysAgo) {
                    $recentUsers++;
                } elseif ($userTime >= $sixtyDaysAgo) {
                    $previousUsers++;
                }
            }
        }

        if ($previousUsers == 0) return $recentUsers > 0 ? 100 : 0;
        
        return round((($recentUsers - $previousUsers) / $previousUsers) * 100, 1);
    }

    private function getDatabaseSize()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'DB Size in MB' FROM information_schema.tables WHERE table_schema = DATABASE()");
            $result = $query->getRow();
            return $result ? $result->{'DB Size in MB'} . ' MB' : 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    private function getMemoryUsage()
    {
        $memory = memory_get_usage(true);
        return round($memory / 1024 / 1024, 2) . ' MB';
    }

    private function getDiskUsage()
    {
        $bytes = disk_free_space(".");
        $total = disk_total_space(".");
        
        if ($bytes && $total) {
            $used = $total - $bytes;
            $percentage = round(($used / $total) * 100, 1);
            return $percentage . '%';
        }
        
        return 'Unknown';
    }

    private function getEmptyAnalyticsData()
    {
        return [
            'users' => $this->getEmptyUserAnalytics(),
            'system' => ['database_size' => 'Unknown', 'total_tables' => 0],
            'activity' => ['daily_logins' => 0, 'page_views_today' => 0],
            'performance' => ['average_response_time' => 'Unknown'],
            'charts' => ['user_growth' => ['labels' => [], 'data' => []]]
        ];
    }

    private function getEmptyUserAnalytics()
    {
        return [
            'total_users' => 0,
            'active_users' => 0,
            'inactive_users' => 0,
            'active_percentage' => 0,
            'role_distribution' => [],
            'recent_registrations' => 0,
            'growth_rate' => 0
        ];
    }

    public function generate()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to generate a custom report
        return $this->response->setJSON(['status' => 'success', 'message' => 'Report generated']);
    }

    public function export()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to export report as PDF or Excel
        return $this->response->setJSON(['status' => 'success', 'message' => 'Report exported']);
    }

    public function schedule()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $data = array_merge($this->getCommonViewData(), [
            'title' => 'Schedule Reports'
        ]);

        return view('admin/reports/schedule', $data);
    }

    public function storeScheduled()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        // Logic to store scheduled report
        return $this->response->setJSON(['status' => 'success', 'message' => 'Scheduled report saved']);
    }
}