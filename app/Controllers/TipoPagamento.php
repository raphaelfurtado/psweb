<?php

namespace App\Controllers;

use App\Models\TipoPagamentoModel;

class TipoPagamento extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $user_role = session()->get('user_role');

        $tipoPagamento = new TipoPagamentoModel();
        $data['tiposPagamento'] = $tipoPagamento->find();
        $data['titulo'] = 'Lista de tipo de pagamento';
        $data['link'] = 'tipoPagamento/inserir';
        $data['role'] = $user_role;
        $data['id_user'] = $user_id;

        echo view('pagamento/tipo_pagamento_index', $data);
    }

    public function inserir()
    {
        if ($this->request->getPost()) {
            $tipoPagamentoModel = new TipoPagamentoModel();
            $dataInsert = [
                'codigo' => $this->request->getPost('codigo'),
                'descricao' => mb_strtoupper($this->request->getPost('descricao')),
                'data_insert' => date('Y-m-d H:i:s'),
            ];
            // Validação e inserção
            if ($tipoPagamentoModel->insert($dataInsert)) {
                // Retorno em caso de sucesso
                return redirect()->to('/tiposPagamento')->with('msg_success', 'Tipo de Pagamento cadastrado com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $tipoPagamentoModel->errors());
            }
        }
        $data['titulo'] = 'Cadastrar Tipo de Pagamento';
        $data['acao'] = 'Inserir';
        $data['tituloRedirect'] = 'Voltar para Lista de Tipos de Pagamentos';
        $data['link'] = '/tiposPagamento';
        $data['tela'] = 'cadastrar';
        $data['acao_form'] = '/tipoPagamento/inserir';

        echo view('pagamento/tipo_pagamento_form', $data);
    }

    public function editar($id)
    {
        $tipoPagamentoModel = new TipoPagamentoModel();
        $tipoPagamento = $tipoPagamentoModel->find($id);

        if (!$tipoPagamento) {
            return redirect()->to('/tiposPagamento')->with('msg_error', 'Tipo de saída não encontrada!');
        }
        // Se o formulário foi enviado, processa a edição
        if ($this->request->getPost()) {
            $data = [
                'id' => $id, // Adiciona o ID no array  
                'codigo' => $this->request->getPost('codigo'),
                'descricao' => mb_strtoupper($this->request->getPost('descricao'))
            ];

            // var_dump($data); 
            // die();

            // Validação e atualização
            if ($tipoPagamentoModel->update($id, $data)) {
                // Retorno em caso de sucesso
                return redirect()->to('/tiposPagamento')->with('msg_success', 'Tipo de saída atualizada com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $tipoPagamentoModel->errors());
            }
        }

        // Passa os dados para o formulário de edição
        $data['tipo_pagamento'] = $tipoPagamento;
        $data['link'] = '/tiposPagamento';
        $data['tituloRedirect'] = 'Voltar para Lista de Tipos de Pagamentos';
        $data['titulo'] = 'Editar Tipo de Pagamento';
        $data['acao'] = 'Atualizar';
        $data['tela'] = 'editar';
        $data['acao_form'] = '/tipoPagamento/editar/' . $id;

        // var_dump($data);
        // die();

        return view('pagamento/tipo_pagamento_form', $data);
    }


    public function desativar($id)
    {
        // Carrega o modelo
        $tipoPagamentoModel = new TipoPagamentoModel();
        // Verifica se o registro existe
        $registro = $tipoPagamentoModel->find($id);
        if (!$registro) {
            // Exibe erro se o registro não for encontrado
            return redirect()->back()->with('msg_error', 'Registro não encontrado.');
        }

        // Atualiza o campo registro_ativo para 0 (inativo)
        $tipoPagamentoModel->update($id, ['registro_ativo' => 0]);

        // Redireciona com uma mensagem de sucesso
        return redirect()->to('/tiposPagamento')->with('msg_success', 'Registro desativado com sucesso.');
    }

    public function ativar($id)
    {
        // Carrega o modelo
        $tipoPagamentoModel = new TipoPagamentoModel();
        // Verifica se o registro existe
        $registro = $tipoPagamentoModel->find($id);
        if (!$registro) {
            // Exibe erro se o registro não for encontrado
            return redirect()->back()->with('msg_error', 'Registro não encontrado.');
        }

        // Atualiza o campo registro_ativo para 0 (inativo)
        $tipoPagamentoModel->update($id, ['registro_ativo' => 1]);

        // Redireciona com uma mensagem de sucesso
        return redirect()->to('/tiposPagamento')->with('msg_success', 'Registro ativado com sucesso.');
    }
}
