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
        // Load IT staff data from database
        $data = [
            'title' => 'IT Staff Management',
            'staff_list' => [] // This would typically come from a model
        ];
        
        return view('itstaff/index', $data);
    }

    /**
     * Show the form for creating a new IT staff member
     * GET /itstaff/create
     */
    public function create()
    {
        $data = [
            'title' => 'Add New IT Staff'
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
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'phone' => 'required|min_length[10]|max_length[15]',
            'department' => 'required',
            'position' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'department' => $this->request->getPost('department'),
            'position' => $this->request->getPost('position'),
            'role' => 'it_staff',
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
            'name' => 'Sample Staff',
            'email' => 'staff@hospital.com',
            'phone' => '1234567890',
            'department' => 'IT',
            'position' => 'System Administrator'
        ];

        if (!$staff) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        }

        $data = [
            'title' => 'Edit IT Staff',
            'staff' => $staff
        ];

        return view('itstaff/edit', $data);
    }

    /**
     * Update the specified IT staff member in storage
     * PUT/PATCH /itstaff/{id}
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
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'phone' => 'required|min_length[10]|max_length[15]',
            'department' => 'required',
            'position' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'department' => $this->request->getPost('department'),
            'position' => $this->request->getPost('position'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update in database (would use ITStaffModel here)
        // $model = new ITStaffModel();
        // $model->update($id, $data);

        return redirect()->to('/itstaff')->with('success', 'IT Staff member updated successfully!');
    }

    /**
     * Remove the specified IT staff member from storage
     * DELETE /itstaff/{id}
     */
    public function delete($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('IT Staff member not found');
        }

        // Check if staff member exists
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
