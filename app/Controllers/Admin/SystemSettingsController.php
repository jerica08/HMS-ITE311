<?php
namespace App\Controllers\Admin;

class SystemSettings extends BaseController
{
    public function index()
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
}