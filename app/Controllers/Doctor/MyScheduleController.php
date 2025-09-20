<?php

namespace App\Controllers\Doctor;

use App\Controllers\BaseController;
use App\Models\StaffModel;
use App\Models\ShiftModel;

class MyScheduleController extends BaseController
{
    public function __construct()
    {
        // Load necessary helpers and libraries
        helper(['url', 'form']);
    }

    /**
     * Display doctor's schedule page
     */
    public function index()
    {
        // Check if user is logged in and has doctor role
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return redirect()->to('/login')->with('error', 'Please login as a doctor to access this page.');
        }

        // Provide currentUser for header consistency
        helper('UserHelper');
        $currentUser = \App\Helpers\UserHelper::getCurrentUser();

        $data = [
            'title' => 'My Schedule',
            'currentUser' => $currentUser,
        ];

        return view('doctor/mySchedule/index', $data);
    }

    /**
     * API: Get shifts for the logged-in doctor
     */
    public function shiftsApi()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $email = session()->get('email');
        $staffModel = new StaffModel();
        $staff = $staffModel->where('email', $email)->where('role', 'doctor')->first();
        if (!$staff) {
            return $this->response->setJSON(['data' => []]);
        }

        $shiftModel = new ShiftModel();
        $rows = $shiftModel
            ->where('staff_id', (int)$staff['id'])
            ->orderBy('date', 'DESC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        $data = array_map(function($r) {
            return [
                'id' => $r['id'] ?? null,
                'date' => $r['date'] ?? null,
                'start' => $r['start_time'] ?? null,
                'end' => $r['end_time'] ?? null,
                'type' => $r['shift_type'] ?? null,
                'department' => $r['department'] ?? null,
                'notes' => $r['notes'] ?? null,
                'repeat_weekly' => $r['repeat_weekly'] ?? 0,
            ];
        }, $rows);

        return $this->response->setJSON(['data' => $data]);
    }

    /**
     * Create a shift for the logged-in doctor
     */
    public function createShift()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return $this->response->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $email = session()->get('email');
        $staffModel = new StaffModel();
        $staff = $staffModel->where('email', $email)->where('role', 'doctor')->first();
        if (!$staff) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Doctor profile not found.']);
        }

        $payload = $this->request->getPost();
        if (!$payload) {
            $payload = $this->request->getJSON(true) ?? [];
        }

        $data = [
            'staff_id' => (int)$staff['id'],
            'date' => $payload['shift_date'] ?? null,
            'shift_type' => $payload['shift_type'] ?? null,
            'start_time' => $payload['start_time'] ?? null,
            'end_time' => $payload['end_time'] ?? null,
            'department' => $payload['location'] ?? ($payload['department'] ?? null),
            'notes' => $payload['notes'] ?? ($payload['notes_shift'] ?? null),
            'repeat_weekly' => isset($payload['repeat_weekly']) ? 1 : 0,
        ];

        $shiftModel = new ShiftModel();
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

    /**
     * Update an existing shift belonging to the logged-in doctor
     */
    public function updateShift($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'doctor') {
            return $this->response->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $email = session()->get('email');
        $staffModel = new StaffModel();
        $staff = $staffModel->where('email', $email)->where('role', 'doctor')->first();
        if (!$staff) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Doctor profile not found.']);
        }

        $shiftModel = new ShiftModel();
        $shift = $shiftModel->find($id);
        if (!$shift || (int)$shift['staff_id'] !== (int)$staff['id']) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Shift not found.']);
        }

        $payload = $this->request->getRawInput();
        if (!$payload) {
            $payload = $this->request->getPost();
        }
        if (!$payload) {
            $payload = $this->request->getJSON(true) ?? [];
        }

        $data = [
            'date' => $payload['shift_date'] ?? ($payload['date'] ?? null),
            'shift_type' => $payload['shift_type'] ?? null,
            'start_time' => $payload['start_time'] ?? null,
            'end_time' => $payload['end_time'] ?? null,
            'department' => $payload['location'] ?? ($payload['department'] ?? null),
            'notes' => $payload['notes'] ?? ($payload['notes_shift'] ?? null),
            'repeat_weekly' => isset($payload['repeat_weekly']) ? 1 : 0,
        ];

        if (!$shiftModel->update($id, $data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $shiftModel->errors(),
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Shift updated successfully'
        ]);
    }
}
