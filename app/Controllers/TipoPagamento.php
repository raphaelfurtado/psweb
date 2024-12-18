<?php

namespace App\Controllers;

use App\Models\TipoPagamentoModel;

class TipoPagamento extends BaseController
{

    public function index()
    {
        $tipoPagamento = new TipoPagamentoModel();
        $data['tiposPagamento'] = $tipoPagamento->find();
        $data['titulo'] = 'Lista de tipo de pagamento';

        echo view('tipos_pagamento', $data);
    }

    public function inserir()
    {
        $data['titulo'] = 'Inserir novo tipo de pagamento';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

        if ($this->request->getPost()) {
            $tipoPagamento = new TipoPagamentoModel();

            $userData = [
                'descricao' => $this->request->getPost('descricao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];



            if ($tipoPagamento->insert($userData)) {
                $data['msg'] = 'Tipo de pagamento inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir tipo de pagamento.';
            }
        }

        echo view('tipo_pagamento_form', $data);
    }
}
