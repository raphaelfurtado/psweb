<?php

namespace App\Controllers;

use App\Models\FormaPagamentoModel;

class FormaPagamento extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $user_role = session()->get('user_role');

        $formaPagamentoModel = new FormaPagamentoModel();
        $data['formasPagamento'] = $formaPagamentoModel->find();
        $data['titulo'] = 'Lista de formas de pagamento';
        $data['link'] = 'formaPagamento/inserir';
        $data['role'] = $user_role;
        $data['id_user'] = $user_id;

        echo view('pagamento/forma_pagamento_index', $data);
    }

    public function inserir()
    {
        if ($this->request->getPost()) {
            $formaPagamentoModel = new FormaPagamentoModel();
            $dataInsert = [
                'codigo' => $this->request->getPost('codigo'),
                'descricao' => mb_strtoupper($this->request->getPost('descricao')),
                'data_insert' => date('Y-m-d H:i:s'),
            ];
            // Validação e inserção
            if ($formaPagamentoModel->insert($dataInsert)) {
                // Retorno em caso de sucesso
                return redirect()->to('/formasPagamento')->with('msg_success', 'Forma de Pagamento cadastrada com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $formaPagamentoModel->errors());
            }
        }
        $data['titulo'] = 'Cadastrar Forma de Pagamento';
        $data['acao'] = 'Inserir';
        $data['tituloRedirect'] = 'Voltar para Lista de Formas de Pagamentos';
        $data['link'] = '/formasPagamento';
        $data['tela'] = 'cadastrar';
        $data['acao_form'] = '/formaPagamento/inserir';

        echo view('pagamento/forma_pagamento_form', $data);
    }

    public function editar($id)
    {
        $formaPagamentoModel = new FormaPagamentoModel();
        $formaPagamento = $formaPagamentoModel->find($id);

        if (!$formaPagamento) {
            return redirect()->to('/formasPagamento')->with('msg_error', 'Forma de pagamento não encontrada!');
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
            if ($formaPagamentoModel->update($id, $data)) {
                // Retorno em caso de sucesso
                return redirect()->to('/formasPagamento')->with('msg_success', 'Forma de pagamento atualizada com sucesso!');
            } else {
                // Retorno em caso de falha
                return redirect()->back()->withInput()->with('errors', $formaPagamentoModel->errors());
            }
        }

        // Passa os dados para o formulário de edição
        $data['forma_pagamento'] = $formaPagamento;
        $data['link'] = '/formasPagamento';
        $data['tituloRedirect'] = 'Voltar para Lista de Formas de Pagamentos';
        $data['titulo'] = 'Editar Forma de Pagamento';
        $data['acao'] = 'Atualizar';
        $data['tela'] = 'editar';
        $data['acao_form'] = '/formaPagamento/editar/' . $id;

        // var_dump($data);
        // die();

        return view('pagamento/forma_pagamento_form', $data);
    }

    public function desativar($id)
    {
        // Carrega o modelo
        $formaPagamentoModel = new FormaPagamentoModel();
        // Verifica se o registro existe
        $registro = $formaPagamentoModel->find($id);
        if (!$registro) {
            // Exibe erro se o registro não for encontrado
            return redirect()->back()->with('msg_error', 'Registro não encontrado.');
        }

        // Atualiza o campo registro_ativo para 0 (inativo)
        $formaPagamentoModel->update($id, ['registro_ativo' => 0]);

        // Redireciona com uma mensagem de sucesso
        return redirect()->to('/formasPagamento')->with('msg_success', 'Registro desativado com sucesso.');
    }

    public function ativar($id)
    {
        // Carrega o modelo
        $formaPagamentoModel = new FormaPagamentoModel();
        // Verifica se o registro existe
        $registro = $formaPagamentoModel->find($id);
        if (!$registro) {
            // Exibe erro se o registro não for encontrado
            return redirect()->back()->with('msg_error', 'Registro não encontrado.');
        }

        // Atualiza o campo registro_ativo para 0 (inativo)
        $formaPagamentoModel->update($id, ['registro_ativo' => 1]);

        // Redireciona com uma mensagem de sucesso
        return redirect()->to('/formasPagamento')->with('msg_success', 'Registro ativado com sucesso.');

    }
}
