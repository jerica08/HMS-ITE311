<?php 
namespace App\Controllers\Nurse;

use App\Controllers\BaseController;

class NurseBaseController extends BaseController
{
    protected function checkNurseAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'nurse') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Nurse only.');
        }
        return null;
    }

    protected function getCurrentUserData()
    {
        helper('UserHelper');
        return \App\Helpers\UserHelper::getCurrentUser();
    }

    public function index()
    {
        $authCheck = $this->checkNurseAuth();
        if ($authCheck) return $authCheck;
        
        $data['currentUser'] = $this->getCurrentUserData();
        return view('nurse/Dashboard/index', $data);
    }
}