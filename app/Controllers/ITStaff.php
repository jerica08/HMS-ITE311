<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ITStaff extends Controller
{
    /**
     * Display a listing of IT staff
     * GET /itstaff
     */
    public function index()
    {
        // Check if user is logged in and has appropriate role
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to access this page.');
        }

        // Load IT staff data from database
        $data = [
            'title' => 'IT Staff Management',
            'itstaff_list' => [] // This would typically come from a model
        ];
        
        return view('itstaff/index', $data);
    }

    /**
     * Show the form for creating a new IT staff member
     * GET /itstaff/create
     */
    public function create()
    {
        // Check if user is logged in and has appropriate role
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in to access this page.');
        }

        $data = [
            'title' => 'Add New IT Staff Member'
        ];
        
        return view('itstaff/create', $data);
    }

    /**
     * Store a newly created IT staff member in storage
     * POST /itstaff
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        // Validation rules
        $validation->setRules([
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'employee_id' => 'required|min_length[3]|max_length[20]',
            'department' => 'required|in_list[network,systems,support,security,database]',
            'position' => 'required|min_length[3]|max_length[100]',
            'status' => 'required|in_list[active,inactive,on_leave]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'employee_id' => $this->request->getPost('employee_id'),
            'department' => $this->request->getPost('department'),
            'position' => $this->request->getPost('position'),
            'status' => $this->request->getPost('status'),
            'hire_date' => $this->request->getPost('hire_date'),
            'notes' => $this->request->getPost('notes'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Save to database (would use ITStaffModel here)
        // $model = new ITStaffModel();
        // $model->save($data);

        return redirect()->to('/itstaff')->with('success', 'IT Staff member added successfully!');
    }

    /**
     * Show the form for editing the specified IT staff member
     * GET /itstaff/edit/{id}
     */
    public function edit($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        }

        // Get IT staff data from database
        // $model = new ITStaffModel();
        // $staff = $model->find($id);
        
        // For now, using dummy data
        $staff = [
            'id' => $id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@hospital.com',
            'phone' => '09123456789',
            'employee_id' => 'IT001',
            'department' => 'systems',
            'position' => 'System Administrator',
            'status' => 'active',
            'hire_date' => '2023-01-15',
            'notes' => 'Experienced system administrator'
        ];

        if (!$staff) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        }

        $data = [
            'title' => 'Edit IT Staff Member',
            'staff' => $staff
        ];

        return view('itstaff/edit', $data);
    }

    /**
     * Update the specified IT staff member in storage
     * POST /itstaff/update/{id}
     */
    public function update($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        }

        $validation = \Config\Services::validation();
        
        // Validation rules
        $validation->setRules([
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'employee_id' => 'required|min_length[3]|max_length[20]',
            'department' => 'required|in_list[network,systems,support,security,database]',
            'position' => 'required|min_length[3]|max_length[100]',
            'status' => 'required|in_list[active,inactive,on_leave]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'employee_id' => $this->request->getPost('employee_id'),
            'department' => $this->request->getPost('department'),
            'position' => $this->request->getPost('position'),
            'status' => $this->request->getPost('status'),
            'hire_date' => $this->request->getPost('hire_date'),
            'notes' => $this->request->getPost('notes'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update in database (would use ITStaffModel here)
        // $model = new ITStaffModel();
        // $model->update($id, $data);

        return redirect()->to('/itstaff')->with('success', 'IT Staff member updated successfully!');
    }

    /**
     * Remove the specified IT staff member from storage
     * GET /itstaff/delete/{id}
     */
    public function delete($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        }

        // Check if IT staff member exists
        // $model = new ITStaffModel();
        // $staff = $model->find($id);
        
        // if (!$staff) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        // }

        // Delete from database
        // $model->delete($id);

        return redirect()->to('/itstaff')->with('success', 'IT Staff member deleted successfully!');
    }
}
