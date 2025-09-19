<?php

namespace App\Controllers\Receptionist;

use App\Controllers\Receptionist\ReceptionistBaseController;

class DoctorApiController extends ReceptionistBaseController
{
    public function byDepartment($department)
    {
        // Auth check for receptionist
        $authError = $this->checkReceptionistAuth();
        if ($authError) {
            return $authError;
        }

        $db = \Config\Database::connect();
        if (!$db->tableExists('users') || !$db->tableExists('staff')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Required tables not found. Run migrations.',
                'data' => []
            ])->setStatusCode(500);
        }

        // Normalize department to match how it's stored (lowercase in some views)
        $department = trim(strtolower($department));

        // Fetch doctors from users joined with staff to get authoritative department and status
        $builder = $db->table('users u')
            ->select('u.id as user_id, u.first_name, u.last_name, u.email, s.department as staff_department, s.status as staff_status, s.role as staff_role')
            ->join('staff s', 's.email = u.email OR (s.employee_id IS NOT NULL AND s.employee_id = u.employee_id)', 'left')
            ->where('u.role', 'doctor')
            ->where('LOWER(s.department)', $department)
            ->orderBy('u.first_name', 'asc')
            ->orderBy('u.last_name', 'asc');

        $rows = $builder->get()->getResultArray();

        // Map data for frontend: id and display name
        $data = array_map(function ($u) {
            $full = trim(($u['first_name'] ?? '') . ' ' . ($u['last_name'] ?? ''));
            $available = strtolower($u['staff_status'] ?? '') === 'active';
            return [
                'id' => $u['user_id'],
                'name' => $full ?: ($u['email'] ?? 'Doctor'),
                'email' => $u['email'] ?? null,
                'department' => $u['staff_department'] ?? null,
                'available' => $available,
            ];
        }, $rows);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
