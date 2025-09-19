<?php

namespace App\Controllers\Admin;
use App\Controllers\Admin\AdminBaseController;

class StaffManagementController extends AdminBaseController
{
    public function index()
    {
        // Ensure admin auth and load common view data
        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $viewData = $this->getCommonViewData();
        return view('admin/staff_management/index', $viewData);
    }

    public function api()
    {
        // Handle API requests for staff data (e.g., return JSON)
        $staffModel = new \App\Models\StaffModel();
        $staff = $staffModel->findAll();
        return $this->response->setJSON($staff);
    }

    public function create()
    {
        // Handle creating a new staff member with validation
        $staffModel = new \App\Models\StaffModel();
        $data = $this->request->getPost([
            'first_name', 'last_name', 'email', 'phone', 'department',
            'role', 'employee_id', 'status', 'hire_date', 'notes'
        ]);

        $id = $staffModel->insert($data);
        if ($id === false) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $staffModel->errors(),
                ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Staff member created',
            'id' => $id,
        ]);
    }

    public function edit($id)
    {
        // Get staff member data for editing
        $staffModel = new \App\Models\StaffModel();
        $staff = $staffModel->find($id);
        return $this->response->setJSON($staff);
    }

    public function update($id)
    {
        // Handle updating a staff member
        $staffModel = new \App\Models\StaffModel();
        $data = $this->request->getRawInput();
        $staffModel->update($id, $data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Staff member updated']);
    }

    public function delete($id)
    {
        // Handle deleting a staff member
        $staffModel = new \App\Models\StaffModel();
        $staffModel->delete($id);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Staff member deleted']);
    }
}   