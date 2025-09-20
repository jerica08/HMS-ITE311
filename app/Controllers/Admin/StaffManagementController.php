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
        // Handle creating a new staff member
        $staffModel = new \App\Models\StaffModel();
        $data = $this->request->getPost();
        $staffModel->insert($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Staff member created']);
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

    public function shifts($id)
    {
        // Ensure admin auth and load common view data
        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        $viewData = $this->getCommonViewData();

        // Load staff info for header/context
        $staffModel = new \App\Models\StaffModel();
        $staff = $staffModel->find($id);
        if (!$staff) {
            return redirect()->to(base_url('admin/staff'))
                ->with('error', 'Staff member not found');
        }

        $viewData['staff'] = $staff;
        return view('admin/staff_management/shifts', $viewData);
    }

    public function shiftsApi($id)
    {
        // Placeholder API for fetching shifts of a staff member
        // In future, integrate with ShiftModel
        $dummy = [
            // Example structure
            // ['date' => '2025-09-20', 'start' => '06:00', 'end' => '14:00', 'type' => 'morning', 'department' => 'Emergency']
        ];
        return $this->response->setJSON(['data' => $dummy]);
    }
}