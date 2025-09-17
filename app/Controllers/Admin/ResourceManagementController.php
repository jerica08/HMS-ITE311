<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminBaseController;

class ResourceManagementController extends AdminBaseController {
    public function index() {
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $data = $this->getCommonViewData();
        return view('admin/resource/resource_management', $data);
    }
}