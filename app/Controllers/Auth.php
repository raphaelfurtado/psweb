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
                session()->set('consent_policy', $user->consent_policy);

                if ($user->consent_policy === 'N') {
                    // Redireciona para uma rota que exibe o modal
                    return redirect()->to('/consent');
                }
                return redirect()->to('/'); // Redireciona para a página inicial após o login
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

    public function updatePolicy()
    {
        $userId = session()->get('user_id'); // Obtém o ID do usuário na sessão

        if ($userId) {
            $userModel = new UserModel();

            // Verifica se o usuário existe no banco de dados
            $usuario = $userModel->find($userId);
            if ($usuario) {
                // Dados a serem atualizados
                $userData = [
                    'consent_policy' => 'S', // Atualiza o campo "consent_policy" para "S"
                ];
                // Tenta atualizar os dados do usuário
                if ($userModel->update($userId, $userData)) {
                    return redirect()->to('/')->with('msg_success', 'Política de privacidade aceita.'); // Redireciona com mensagem de sucesso
                } else {
                    return redirect()->to('/login')->with('error', 'Erro de validação, entre em contato com a administração.'); // Redireciona com mensagem de erro
                }
            } else {
                return redirect()->to('/login')->with('error', 'Erro de validação, entre em contato com a administração.'); // Redireciona caso o usuário não seja encontrado
            }
        } else {
            return redirect()->to('/login')->with('error', 'Erro de validação, entre em contato com a administração.'); // Redireciona caso o ID do usuário esteja ausente
        }
    }

    public function consent()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login'); // Garante que apenas usuários logados acessem a página
        }
        return view('consent'); // Exibe a página com o modal
    }
}
