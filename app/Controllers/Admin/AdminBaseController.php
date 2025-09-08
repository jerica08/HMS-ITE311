<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminBaseController extends BaseController
{
    protected function checkAdminAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Admins only.');
        }
        return null;
    }

    protected function getCurrentUserData()
    {
        helper('UserHelper');
        return \App\Helpers\UserHelper::getCurrentUser();
    }

    protected function getCommonViewData()
    {
        return [
            'currentUser' => $this->getCurrentUserData()
        ];
    }
}
