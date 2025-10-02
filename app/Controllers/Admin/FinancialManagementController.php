<?php

namespace App\Controllers\Admin;
use App\Controllers\Admin\AdminBaseController;

class FinancialManagementController extends AdminBaseController
{
    public function index()
    {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Financial Management',
            'currentUser' => $currentUser
        ];

        // Corrected view path to match existing file structure
        // File exists at: app/Views/admin/financial-management/financial_management.php
        return view('admin/financial-management/financial_management', $data);
    }
}