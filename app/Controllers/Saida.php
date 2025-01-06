<?php

namespace App\Controllers;

use App\Models\FormaPagamentoModel;
use App\Models\PagamentoModel;
use App\Models\RecebedorModel;
use App\Models\SaidaModel;
use App\Models\TipoPagamentoModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Config\Database;

class Saida extends BaseController
{

    public function index()
    {
        $saidaModel = new SaidaModel();
        $pagamentoModel = new PagamentoModel();

        $data['link'] = 'saida/inserir';
        $data['tituloRedirect'] = '+ Inserir Nova Saída';
        $data['saidas'] = $saidaModel
            ->select('saida.*,
                tipo_pagamento.descricao as desc_pagamento
              ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            ->orderBy('saida.id', 'DESC')->findAll();

        //echo $saidaModel->getLastQuery();

        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();
        
        $data['titulo'] = 'Lista de Saída';
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;

        echo view('saidas', $data);
    }

    public function inserir()
    {
        $recebedoresModel = new RecebedorModel();
        $tipoPagamentoModel = new TipoPagamentoModel();
        $formaPagamentoModel = new FormaPagamentoModel();
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();

        $data['link'] = '/saidas';
        $data['tituloRedirect'] = 'Voltar para Lista de Saídas';
        $data['titulo'] = 'Inserir Saída';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

        if ($this->request->getPost()) {
            $saidaData = [
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'valor' => $this->request->getPost('valor'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $saidaData = $saidaModel->insert($saidaData);

            if ($saidaData) {
                $data['msg'] = 'Saída inserida com sucesso!';
            } else {
                $data['msg'] = 'Erro ao inserir pagamento.';
            }
        }

        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();

        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;

        echo view('saida_form', $data);
    }

    public function editar($id)
    {
        $tipoPagamentoModel = new TipoPagamentoModel();
        $saidaModel = new SaidaModel();
        $formaPagamentoModel = new FormaPagamentoModel();
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();

        $data['titulo'] = 'Editar Saída ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/saidas';
        $data['tituloRedirect'] = 'Voltar para Lista de Saídas';

        $saida = $saidaModel->find($id);

        if (!$saida) {
            return redirect()->to('/users')->with('error', 'Saída não encontrado.');
        }

        if ($this->request->getPost()) {

            $saidaData = [
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'valor' => $this->request->getPost('valor'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $saidaData = $saidaModel->update($id, $saidaData);

            if ($saidaData) {
                $data['msg'] = 'Saída atualizada com sucesso!';
            } else {
                $data['msg'] = 'Erro ao atualizar saída.';
            }

            return redirect()->to('/saidas');
        }

        $data['saida'] = $saida;
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;

        echo view('saida_form', $data);
    }

    public function gerarPagamentosForm()
    {

        $data['link'] = '/pagamentos';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamentos';
        $data['titulo'] = 'Gerar Pagamentos';
        $data['acao'] = 'Gerar';
        $data['msg'] = '';

        return view('gerar_pagamentos', $data);
    }

    public function gerarPagamentos()
    {
        // Recupera o ano do formulário
        $ano = $this->request->getPost('ano');

        if (!$ano) {
            return redirect()->back()->with('error', 'Ano é obrigatório.');
        }

        try {
            // Executa a procedure no banco de dados
            $db = Database::connect();
            $db->query("CALL gerar_pagamentos_ano_flexivel($ano)");

            // Retorno de sucesso
            return redirect()->to('/gerarPagamentos')->with('success', 'Pagamentos gerados com sucesso.');
        } catch (DatabaseException $e) {
            // Caso ocorra algum erro na execução da procedure
            return redirect()->back()->with('error', 'Erro ao gerar pagamentos: ' . $e->getMessage());
        }
    }
}
