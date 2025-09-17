<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SystemSettingsController extends BaseController
{
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
        $data = [
            'title' => 'System Settings',
            'currentUser' => $currentUser
        ];

        return view('admin/system-setting/system_settings', $data);
    }
}