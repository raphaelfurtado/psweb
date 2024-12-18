<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EnderecoModel;

class User extends BaseController
{

    public function index()
    {
        $userModel = new UserModel();
        $data['moradores'] = $userModel->find();
        $data['titulo'] = 'Lista de moradores';
        $data['link'] = 'public/index.php/user/inserir';
        $data['tituloRedirect'] = '+ Inserir Novo Usuário';

        echo view('moradores', $data);
    }

    public function inserir()
    {
        $data['titulo'] = 'Inserir novo usuário';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';
        $data['link'] = 'public/index.php/users';
        $data['tituloRedirect'] = 'Voltar para Lista de Usuários';

        if ($this->request->getPost()) {
            $userModel = new UserModel();
            $enderecoModel = new EnderecoModel();

            $userData = [
                'nome' => $this->request->getPost('nome'),
                'aniversario' => $this->request->getPost('aniversario'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
            ];

            $userId = $userModel->insert($userData, true); // `true` retorna o ID do registro inserido

            if ($userId) {
                $enderecoData = [
                    'id_usuario' => $userId, // Relaciona o endereço ao usuário
                    'rua' => $this->request->getPost('rua'),
                    'numero' => $this->request->getPost('numero'),
                    'quadra' => $this->request->getPost('quadra'),
                    'data_insert' => date('Y-m-d H:i:s'),
                ];

                if ($enderecoModel->insert($enderecoData)) {
                    $data['msg'] = 'Usuário e endereço inseridos com sucesso!';
                } else {
                    $data['msg'] = 'Usuário inserido, mas ocorreu um erro ao salvar o endereço.';
                }
            } else {
                $data['msg'] = 'Erro ao inserir usuário.';
            }
        }

        echo view('user_form', $data);
    }

    public function editar($id)
    {
        $data['titulo'] = 'Editar usuário ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = 'public/index.php/users';
        $data['tituloRedirect'] = 'Voltar para Lista de Usuários';

        $userModel = new UserModel();
        $enderecoModel = new EnderecoModel();

        $usuario = $userModel->find($id);
        $endereco = $enderecoModel->getEnderecoByUsuarioId($id);

        if (!$usuario) {
            return redirect()->to('/users')->with('error', 'Usuário não encontrado.');
        }

        if ($this->request->getPost()) {
        
            $enderecoModel->where('id_usuario', $id)->set([
                    'rua' => $this->request->getPost('rua'),
                    'numero' => $this->request->getPost('numero'),
                    'quadra' => $this->request->getPost('quadra'),
            ])->update();

            if ($userModel->update($id, [
                'nome' => $this->request->getPost('nome'),
                'aniversario' => $this->request->getPost('aniversario'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
            ])) {
                $data['msg'] = 'Usuário e endereço atualizados com sucesso!';
            } else {
                $data['msg'] = 'Erro ao atualizar o endereço.';
            };

            //return redirect()->to('/users');
        }

        $data['usuario'] = $usuario;
        $data['endereco'] = $endereco;

        echo view('user_form', $data);
    }
}
