<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verifica se o usuário está logado
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Você precisa estar logado para acessar esta página.');
        }

        // Se o usuário não aceitou a política de privacidade, redireciona para a página de consentimento
        if (session()->get('consent_policy') === 'N' && $request->uri->getPath() !== 'consent') {
            return redirect()->to('/login');  // Redireciona para a página de consentimento
        }

        // Verifica a role do usuário (admin ou user) e a política de privacidade
        if (isset($arguments[0]) && $arguments[0] === 'admin' && session()->get('user_role') !== 'admin') {
            return redirect()->to('/');  // Redireciona para a dashboard se o usuário não for admin
        }

        // Se o usuário já estiver logado e acessar a página de login, redireciona para a dashboard
        if (session()->get('user_id') && $request->uri->getPath() === 'login' && session()->get('consent_policy') === 'S') {
            return redirect()->to('/');  // Redireciona para a página inicial após o login
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer após a execução da ação
    }
}
