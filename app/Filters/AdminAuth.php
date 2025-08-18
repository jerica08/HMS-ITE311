<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');
        
        // Check if user is logged in
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }
        
        // Check if user has admin role
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Admin privileges required.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing after the request
    }
}