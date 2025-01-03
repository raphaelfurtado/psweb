<?php

namespace App\Controllers;

use App\Models\FormaPagamentoModel;

class FormaPagamento extends BaseController
{

    public function index()
    {
        $tipoPagamento = new FormaPagamentoModel();
        $data['formasPagamento'] = $tipoPagamento->find();
        $data['titulo'] = 'Lista de formas de pagamento';
        $data['tituloRedirect'] = '+ Inserir Nova Forma de Pagamento';
        $data['link'] = 'formaPagamento/inserir';

        echo view('formas_pagamento', $data);
    }

    public function inserir()
    {
        $data['titulo'] = 'Inserir nova forma de pagamento';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';
        $data['link'] = '/formasPagamento';
        $data['tituloRedirect'] = 'Voltar para Lista de Forma de Pagamento';

        if ($this->request->getPost()) {
            $tipoPagamento = new FormaPagamentoModel();

            $userData = [
                'codigo' => $this->request->getPost('codigo'),
                'descricao' => $this->request->getPost('descricao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];



            if ($tipoPagamento->insert($userData)) {
                $data['msg'] = 'Forma de pagamento inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir forma de pagamento.';
            }
        }

        echo view('forma_pagamento_form', $data);
    }
}
