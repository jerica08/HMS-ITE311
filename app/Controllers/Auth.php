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
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password']) && $user['role'] === $role) {
            // Set session
            $this->session->set([
                'email'     => $user['email'],
                'username'  => $user['username'],
                'role'      => $user['role'],
                'logged_in' => true
            ]);
            
            // Redirect based on role
            return redirect()->to('/' . $role . '/dashboard');
        }

        // If login fails, redirect back to login with error message
        return redirect()->to('/login')->with('error', 'Invalid username and password');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
