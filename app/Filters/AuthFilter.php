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
            return redirect()->to('/login')->with('error', 'Você precisa estar logado para acessar esta página.');;
        }

        // Verifica a role do usuário (admin ou user)
        if (isset($arguments[0]) && $arguments[0] === 'admin' && session()->get('user_role') !== 'admin') {
            return redirect()->to('/');
        }
        
        // Se o usuário já estiver logado e acessar a página de login, redirecione para a dashboard
        if (session()->get('user_id') && $request->uri->getPath() === 'login') {
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer após a execução da ação
    }
}
