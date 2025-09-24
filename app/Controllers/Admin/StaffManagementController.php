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
        // Return actual shifts for a staff member
        $shiftModel = new \App\Models\ShiftModel();
        $rows = $shiftModel
            ->where('staff_id', (int)$id)
            ->orderBy('date', 'DESC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        $data = array_map(function($r) {
            return [
                'date' => $r['date'] ?? null,
                'start' => $r['start_time'] ?? null,
                'end' => $r['end_time'] ?? null,
                'type' => $r['shift_type'] ?? null,
                'department' => $r['department'] ?? null,
                'notes' => $r['notes'] ?? null,
            ];
        }, $rows);

        return $this->response->setJSON(['data' => $data]);
    }

    public function doctors()
    {
        // Return active doctors for select options
        $model = new \App\Models\StaffModel();
        $rows = $model
            ->select('id, first_name, last_name')
            ->where('role', 'doctor')
            ->where('status', 'active')
            ->orderBy('last_name', 'ASC')
            ->findAll();

        $doctors = array_map(function($r) {
            $first = trim($r['first_name'] ?? '');
            $last = trim($r['last_name'] ?? '');
            $name = trim(($last ? $last . ', ' : '') . $first);
            if ($name === '') { $name = 'Doctor #' . ($r['id'] ?? ''); }
            return [
                'id' => $r['id'],
                'name' => $name,
            ];
        }, $rows);

        return $this->response->setJSON(['doctors' => $doctors]);
    }

    public function createShift($staffId)
    {
        // Ensure admin auth
        if ($redirect = $this->checkAdminAuth()) {
            return $redirect;
        }

        // Validate staff exists and is a doctor
        $staffModel = new \App\Models\StaffModel();
        $staff = $staffModel->find($staffId);
        if (!$staff || strtolower($staff['role'] ?? '') !== 'doctor') {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Invalid doctor selected.'
            ]);
        }

        $payload = $this->request->getPost();
        // Allow both FormData and JSON raw input
        if (!$payload) {
            $payload = $this->request->getJSON(true) ?? [];
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'employee_id' => $this->request->getPost('employee_id'),
            'hire_date' => $this->request->getPost('hire_date'),
            'notes' => $this->request->getPost('notes'),
            'status' => 'active', // Default status
            'role' => null, // Will be set when linked to user
            'department' => null // Will be set when linked to user
        ];

        $shiftModel = new \App\Models\ShiftModel();
        if (!$shiftModel->insert($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $shiftModel->errors(),
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Shift created successfully'
        ]);
    }
}