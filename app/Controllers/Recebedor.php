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

        echo view('recebedores', $data);
    }

    public function inserir()
    {
        $data['titulo'] = 'Inserir Recebedor';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

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
}
