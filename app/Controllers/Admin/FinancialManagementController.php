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

        return view('admin/financial/financial_management', $data);
    }
}