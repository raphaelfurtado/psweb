<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->getPost()) {
            $celular = $this->request->getPost('telefone');

            // Limpa o número de telefone, removendo caracteres não numéricos
            $celular = preg_replace('/[^0-9]/', '', $celular);

            $senha = $this->request->getPost('senha');

            $userModel = new UserModel();
            $user = $userModel->login($celular, $senha);

            if ($user) {
                session()->set('user_id', $user->id);
                session()->set('user_nome', $user->nome);
                session()->set('user_role', $user->role);
                session()->set('logged_in', true);

                return redirect()->to('/');
            } else {
                session()->setFlashdata('error', 'Credenciais inválidas');
            }
        }

        return view('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
