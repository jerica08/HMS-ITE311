<?php 
namespace App\Controllers\Receptionist;

use App\Controllers\BaseController;

class ReceptionistBaseController extends BaseController
{
    protected function checkReceptionistAuth()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'receptionist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access. Receptionists only.');
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