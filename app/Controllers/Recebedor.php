<?php

namespace App\Controllers;

use App\Models\RecebedorModel;

class Recebedor extends BaseController
{

    public function index()
    {
        $recebedorModel = new RecebedorModel();
        $data['recebedores'] = $recebedorModel->find();
        $data['titulo'] = 'Lista de Recebedores';
        $data['tituloRedirect'] = '+ Inserir Novo Recebedor';
        $data['link'] = '/recebedor/inserir';

        echo view('recebedores', $data);
    }

    public function inserir()
    {
        $data['titulo'] = 'Inserir Recebedor';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';
        $data['link'] = '/recebedores';
        $data['tituloRedirect'] = 'Voltar para Lista de Recebedores';

        if ($this->request->getPost()) {
            $recebedorModel = new RecebedorModel();

            $recebedorData = [
                'nome' => $this->request->getPost('nome'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
                'data_nascimento' => $this->request->getPost('data_nascimento'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $recebedor = $recebedorModel->insert($recebedorData);

            if ($recebedor) {
                $data['msg'] = 'Recebedor inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir recebedor.';
            }
        }

        echo view('recebedor_form', $data);
    }

    public function editar($id)
    {

        $data['titulo'] = 'Editar usuário ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/users';
        $data['tituloRedirect'] = 'Voltar para Lista de Usuários';

        $recebedorModel = new RecebedorModel();

        $recebedor = $recebedorModel->find($id);

        if (!$recebedor) {
            return redirect()->to('/recebedores')->with('error', 'Recebedor não encontrado.');
        }

        if ($this->request->getPost()) {

            $recebedorData = [
                'nome' => $this->request->getPost('nome'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
                'data_nascimento' => $this->request->getPost('data_nascimento'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            if ($recebedorModel->update($id, $recebedorData)) {
                $data['msg'] = 'Recebedor atualizado com sucesso!';
            } else {
                $data['msg'] = 'Erro ao atualizar o Recebedor.';
            };

            return redirect()->to('/recebedores');
        }


        // Dados para a visualização
        $data = [
            'titulo' => 'Editar Recebedor ' . $id,
            'acao' => 'Atualizar',
            'msg' => '',
            'link' => '/recebedores',
            'tituloRedirect' => 'Voltar para Lista de Recebedores',
            'recebedor' => $recebedor
        ];

        echo view('recebedor_form', $data);
    }
}
