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
        $staffModel = new \App\Models\StaffModel();
        $staff = $staffModel->findAll();
        return $this->response->setJSON($staff);
    }

    public function create()
    {
        // Handle creating a new staff member
        $staffModel = new \App\Models\StaffModel();
        // Accept both traditional form posts and raw JSON bodies
        $payload = $this->request->getPost();
        if (!$payload || count($payload) === 0) {
            $json = $this->request->getJSON(true);
            if (is_array($json)) {
                $payload = $json;
            } else {
                $payload = [];
            }
        }

        // Map new form fields to model fields
        // Support either full_name or explicit first_name/last_name
        $firstName = trim((string)($payload['first_name'] ?? ''));
        $lastName = trim((string)($payload['last_name'] ?? ''));
        if ($firstName === '' && $lastName === '') {
            $fullName = trim((string)($payload['full_name'] ?? ''));
            if ($fullName !== '') {
                $firstName = $fullName;
                if (strpos($fullName, ' ') !== false) {
                    $parts = preg_split('/\s+/', $fullName);
                    $lastName = array_pop($parts);
                    $firstName = trim(implode(' ', $parts));
                }
            }
        }

        // Normalize dates to Y-m-d for DB columns
        $rawJoined = $payload['date_joined'] ?? null;
        $dateJoined = null;
        if (is_string($rawJoined) && $rawJoined !== '') {
            $dt = \DateTime::createFromFormat('Y-m-d', $rawJoined) ?: \DateTime::createFromFormat('d/m/Y', $rawJoined);
            if ($dt instanceof \DateTime) {
                $dateJoined = $dt->format('Y-m-d');
            }
        }
        $rawDob = $payload['dob'] ?? null;
        $dob = null;
        if (is_string($rawDob) && $rawDob !== '') {
            $dd = \DateTime::createFromFormat('Y-m-d', $rawDob) ?: \DateTime::createFromFormat('d/m/Y', $rawDob);
            if ($dd instanceof \DateTime) {
                $dob = $dd->format('Y-m-d');
            }
        }

        $data = [
            'employee_id' => $payload['employee_code'] ?? ($payload['employee_id'] ?? null),
            'first_name'  => $firstName,
            'last_name'   => $lastName,
            'gender'      => isset($payload['gender']) ? strtolower((string)$payload['gender']) : null,
            'dob'         => $dob,
            'contact_no'  => $payload['contact_no'] ?? ($payload['phone'] ?? null),
            'email'       => $payload['email'] ?? null,
            'address'     => $payload['address'] ?? null,
            'department'  => $payload['department'] ?? null,
            'designation' => $payload['designation'] ?? null,
            'role'        => isset($payload['designation']) ? str_replace(' ', '_', strtolower(trim((string)$payload['designation']))) : (isset($payload['role']) ? strtolower(trim((string)$payload['role'])) : null),
            'date_joined' => $dateJoined,
        ];

        // Insert will run validation and beforeInsert hooks
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

        $created = $staffModel->find($id);
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Staff member created',
            'data' => $created,
        ]);
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