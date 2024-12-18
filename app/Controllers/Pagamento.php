<?php

namespace App\Controllers;

use App\Models\PagamentoModel;
use App\Models\RecebedorModel;
use App\Models\TipoPagamentoModel;
use App\Models\UserModel;

class Pagamento extends BaseController
{

    public function index()
    {
        $pagadorModel = new PagamentoModel();

        $data['link'] = 'pagamento/inserir';
        $data['tituloRedirect'] = '+ Inserir Novo Pagamento';
        $data['pagamentos'] = $pagadorModel
            ->select('pagamento.*, 
                pagamento.id as id_pagamento,
                users.nome as nome_morador, 
                recebedor.nome as nome_recebedor, 
                endereco.*,
                tipo_pagamento.descricao as desc_pagamento
              ')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('recebedor', 'recebedor.id = pagamento.id_recebedor')
            ->join('endereco', 'endereco.id_usuario = users.id')
            ->join('tipo_pagamento', 'tipo_pagamento.id = pagamento.id_tipo_pagamento')
            ->orderBy('pagamento.id', 'DESC')->paginate(10);

        $data['pager'] = $pagadorModel->pager;
        $data['titulo'] = 'Lista de Pagamento';

        echo view('pagamentos', $data);
    }

    public function inserir()
    {
        $recebedoresModel = new RecebedorModel();
        $moradorModel = new UserModel();
        $tipoPagamentoModel = new TipoPagamentoModel();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['moradores'] = $moradorModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();

        $data['link'] = '/pagamentos';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamentos';
        $data['titulo'] = 'Inserir Pagador';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

        if ($this->request->getPost()) {
            $pagadorModel = new PagamentoModel();

            $pagadorData = [
                'id_usuario' => $this->request->getPost('morador'),
                'id_recebedor' => $this->request->getPost('recebedor'),
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $this->request->getPost('valor'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $pagadorData = $pagadorModel->insert($pagadorData);

            if ($pagadorData) {
                $data['msg'] = 'Pagamento inserido com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir pagamento.';
            }
        }

        echo view('pagamento_form', $data);
    }

    public function editar($id)
    {
        $recebedoresModel = new RecebedorModel();
        $moradorModel = new UserModel();
        $tipoPagamentoModel = new TipoPagamentoModel();
        $pagadorModel = new PagamentoModel();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['moradores'] = $moradorModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();

        $data['titulo'] = 'Editar Pagamento ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/pagamentos';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamentos';

        $pagamento = $pagadorModel->find($id);

        if (!$pagamento) {
            return redirect()->to('/users')->with('error', 'Pagamento não encontrado.');
        }

        if ($this->request->getPost()) {
            $pagadorModel = new PagamentoModel();

            $pagadorData = [
                'id_recebedor' => $this->request->getPost('recebedor'),
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $this->request->getPost('valor'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $pagadorData = $pagadorModel->update($id, $pagadorData);

            if ($pagadorData) {
                $data['msg'] = 'Pagamento atualizado com sucesso!';
            } else {
                $data['msg'] = 'Erro ao atualizar pagamento.';
            }

            return redirect()->to('/pagamentos');
        }

        $data['pagamento'] = $pagamento;

        echo view('pagamento_form', $data);
    }
}
