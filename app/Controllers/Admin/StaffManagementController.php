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
        // Handle creating a new staff member (validated and aligned to DB schema)
        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $staffModel = new \App\Models\StaffModel();
        $data = $this->request->getPost();

        // Map UI field 'role' to DB column 'position'
        if (!empty($data['role'])) {
            $data['position'] = $data['role'];
            unset($data['role']);
        }
        // Notes field is not in schema; drop it if present
        if (isset($data['notes'])) {
            unset($data['notes']);
        }

        // Whitelist payload to allowed fields
        $payload = [
            'employee_id' => $data['employee_id'] ?? null,
            'first_name'  => $data['first_name'] ?? null,
            'middle_name' => $data['middle_name'] ?? null,
            'last_name'   => $data['last_name'] ?? null,
            'position'    => $data['position'] ?? null,
            'department'  => $data['department'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'email'       => $data['email'] ?? null,
            'hire_date'   => $data['hire_date'] ?? null,
            'status'      => $data['status'] ?? 'active',
        ];

        if (!$staffModel->insert($payload)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $staffModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Staff member created',
            'staff_id' => $staffModel->getInsertID()
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

    public function createUserForStaff($id)
    {
        // Ensure admin auth
        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $staffModel = new \App\Models\StaffModel();
        $userModel  = new \App\Models\UserModel();

        $staff = $staffModel->find($id);
        if (!$staff) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Staff not found'
            ]);
        }

        $data = $this->request->getPost();
        // Expected POST fields: username, email, password, role, status(optional)
        $payload = [
            'username'    => $data['username'] ?? null,
            'email'       => $data['email'] ?? null,
            'password'    => $data['password'] ?? null,
            'role'        => $data['role'] ?? 'receptionist',
            'status'      => $data['status'] ?? 'active',
            'first_name'  => $staff['first_name'] ?? null,
            'last_name'   => $staff['last_name'] ?? null,
            'department'  => $staff['department'] ?? null,
            'employee_id' => $staff['employee_id'] ?? null,
            'hire_date'   => $staff['hire_date'] ?? null,
            'staff_id'    => (int) $id,
        ];

        if (!$userModel->insert($payload)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $userModel->errors()
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'User account created for staff',
            'user_id' => $userModel->getInsertID()
        ]);
    }
}