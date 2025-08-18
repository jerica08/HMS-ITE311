<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('login');
    }

    public function loginSubmit()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $this->session->set([
                'username'  => $user['username'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            }
        }

        // If login fails, redirect back to login
        return redirect()->to('/login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
