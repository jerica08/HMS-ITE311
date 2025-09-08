<?php

namespace App\Controllers\Admin;
use App\Controllers\Admin\AdminBaseController;

class CommunicationController extends AdminBaseController{
    
    public function index(){
        $authCheck = $this->checkAdminAuth();
        if ($authCheck) return $authCheck;

        $currentUser = $this->getCurrentUserData();
        $data = [
            'title' => 'Communication & Notifications',
            'currentUser' => $currentUser
        ];

        return view('admin/communication/communication', $data);
    }
}