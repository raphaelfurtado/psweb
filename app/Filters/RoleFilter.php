<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = [])
    {

        $arguments = is_array($arguments) ? $arguments : [];

        // Verifica se o usuário está autenticado
        if (!session()->has('logged_in') || !session()->get('logged_in')) {
            return redirect()->to('/login'); // Redireciona para a página de login
        }

        // Obtém o papel do usuário da sessão
        $role = session()->get('user_role');

        if (!in_array($role, $arguments)) {
            if ($request->getUri()->getPath() !== '/') {
                return redirect()->to('/');
            }
        }

        // Permite o acesso
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer após a execução da requisição
    }
}
