<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Verifica se o usuário está logado
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }

        $data['titulo'] = 'Painel do Usuário';
        $data['nome'] = session()->get('user_nome');
        $data['role'] = session()->get('user_role');

        return view('dashboard', $data);
    }
}
