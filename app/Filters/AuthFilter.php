<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        // Verifica a role do usuário (admin ou user)
        if (isset($arguments[0]) && $arguments[0] === 'admin' && session()->get('user_role') !== 'admin') {
            return redirect()->to('/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer após a execução da ação
    }
}
