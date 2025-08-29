<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Laboratories extends Controller
{
    /**
     * Display a listing of laboratories
     * GET /laboratories
     */
    public function index()
    {
        // Load laboratories data from database
        $data = [
            'title' => 'Laboratory Management',
            'laboratories_list' => [] // This would typically come from a model
        ];
        
        return view('laboratories/index', $data);
    }

    /**
     * Show the form for creating a new laboratory
     * GET /laboratories/create
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Laboratory'
        ];
        
        return view('laboratories/create', $data);
    }

    /**
     * Store a newly created laboratory in storage
     * POST /laboratories
     */
    public function store()
    {
        $validation = \Config\Services::validation();
        
        // Validation rules
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'location' => 'required|min_length[3]|max_length[200]',
            'equipment' => 'required',
            'capacity' => 'required|numeric|greater_than[0]',
            'status' => 'required|in_list[active,inactive,maintenance]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'equipment' => $this->request->getPost('equipment'),
            'capacity' => $this->request->getPost('capacity'),
            'status' => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Save to database (would use LaboratoriesModel here)
        // $model = new LaboratoriesModel();
        // $model->save($data);

        return redirect()->to('/laboratories')->with('success', 'Laboratory added successfully!');
    }

    /**
     * Show the form for editing the specified laboratory
     * GET /laboratories/edit/{id}
     */
    public function edit($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laboratory not found');
        }

        // Get laboratory data from database
        // $model = new LaboratoriesModel();
        // $laboratory = $model->find($id);
        
        // For now, using dummy data
        $laboratory = [
            'id' => $id,
            'name' => 'Sample Laboratory',
            'location' => 'Building A, Floor 2',
            'equipment' => 'Microscopes, Centrifuge, Blood Analyzer',
            'capacity' => 20,
            'status' => 'active',
            'description' => 'General purpose laboratory'
        ];

        if (!$laboratory) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laboratory not found');
        }

        $data = [
            'title' => 'Edit Laboratory',
            'laboratory' => $laboratory
        ];

        return view('laboratories/edit', $data);
    }

    /**
     * Update the specified laboratory in storage
     * PUT/PATCH /laboratories/{id}
     */
    public function update($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laboratory not found');
        }

        $validation = \Config\Services::validation();
        
        // Validation rules
        $validation->setRules([
            'name' => 'required|min_length[3]|max_length[100]',
            'location' => 'required|min_length[3]|max_length[200]',
            'equipment' => 'required',
            'capacity' => 'required|numeric|greater_than[0]',
            'status' => 'required|in_list[active,inactive,maintenance]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Get form data
        $data = [
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'equipment' => $this->request->getPost('equipment'),
            'capacity' => $this->request->getPost('capacity'),
            'status' => $this->request->getPost('status'),
            'description' => $this->request->getPost('description'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update in database (would use LaboratoriesModel here)
        // $model = new LaboratoriesModel();
        // $model->update($id, $data);

        return redirect()->to('/laboratories')->with('success', 'Laboratory updated successfully!');
    }

    /**
     * Remove the specified laboratory from storage
     * DELETE /laboratories/{id}
     */
    public function delete($id)
    {
        // Validate ID
        if (!is_numeric($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laboratory not found');
        }

        // Check if laboratory exists
        // $model = new LaboratoriesModel();
        // $laboratory = $model->find($id);
        
        // if (!$laboratory) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Laboratory not found');
        // }

        // Delete from database
        // $model->delete($id);

        return redirect()->to('/laboratories')->with('success', 'Laboratory deleted successfully!');
    }
}
