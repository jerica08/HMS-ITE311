<?php

namespace App\Helpers;

use App\Models\UserModel;

class UserHelper
{
    /**
     * Get current logged-in user information
     * 
     * @return array User data with name, role, and other details
     */
    public static function getCurrentUser()
    {
        // Get basic session data
        $userData = [
            'user_id' => session()->get('user_id'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
            'first_name' => '',
            'last_name' => '',
            'username' => '',
            'department' => ''
        ];

        // Fetch additional user details from database if user_id exists
        if ($userData['user_id']) {
            $userModel = new UserModel();
            $user = $userModel->find($userData['user_id']);
            
            if ($user) {
                $userData['first_name'] = $user['first_name'] ?? '';
                $userData['last_name'] = $user['last_name'] ?? '';
                $userData['username'] = $user['username'] ?? '';
                $userData['department'] = $user['department'] ?? '';
            }
        }

        return $userData;
    }

    /**
     * Get display name for current user
     * 
     * @param array|null $userData Optional user data array
     * @return string Formatted display name
     */
    public static function getDisplayName($userData = null)
    {
        if ($userData === null) {
            $userData = self::getCurrentUser();
        }

        $fullName = trim(($userData['first_name'] ?? '') . ' ' . ($userData['last_name'] ?? ''));
        return !empty($fullName) ? $fullName : ($userData['username'] ?? $userData['email'] ?? 'User');
    }

    /**
     * Get display role for current user
     * 
     * @param array|null $userData Optional user data array
     * @return string Formatted role name
     */
    public static function getDisplayRole($userData = null)
    {
        if ($userData === null) {
            $userData = self::getCurrentUser();
        }

        $role = $userData['role'] ?? 'admin';
        $roleDisplayNames = [
            'admin' => 'Hospital Administrator',
            'doctor' => 'Doctor',
            'nurse' => 'Nurse',
            'receptionist' => 'Receptionist',
            'pharmacist' => 'Pharmacist',
            'accountant' => 'Accountant',
            'laboratorist' => 'Laboratory Staff',
            'it_staff' => 'IT Staff'
        ];

        return $roleDisplayNames[$role] ?? ucfirst($role);
    }
}
