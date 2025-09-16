<?php 
namespace App\Controllers\Nurse;

use App\Controllers\Nurse\NurseBaseController;

class ShiftReportController extends NurseBaseController
{
    public function index()
    {
        $authCheck = $this->checkNurseAuth();
        if ($authCheck) return $authCheck;
        
        $data['currentUser'] = $this->getCurrentUserData();
        return view('nurse/Shift-Report/index', $data);
    }
}