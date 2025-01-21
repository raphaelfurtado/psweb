<?php

namespace App\Controllers;

use App\Models\FormaPagamentoModel;
use App\Models\FuncionarioModel;
use App\Models\PagamentoModel;
use App\Models\RecebedorModel;
use App\Models\SaidaModel;
use App\Models\TipoPagamentoModel;
use App\Models\TipoSaidaModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Config\Database;

class PagamentoFuncionario extends BaseController
{

    public function index()
    {
        $saidaModel = new SaidaModel();
        $pagamentoModel = new PagamentoModel();

        $data['link'] = 'pagamentoFuncionario/inserirPagamentoFuncionario';
        $data['tituloRedirect'] = '+ Inserir Nova Saída';
        $data['saidas'] = $saidaModel
            ->select('saida.*,
                tipo_pagamento.descricao as desc_pagamento,
                tipo_saida.descricao as desc_saida,
                funcionarios.nome_completo as nome_completo,
                funcionarios.salario as salario,
                funcionarios.telefone_whatsapp as telefone
              ')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = saida.id_tipo_pagamento')
            ->join('tipo_saida', 'tipo_saida.codigo = saida.id_tipo_saida')
            ->join('funcionarios', 'funcionarios.id = saida.id_funcionario')
            ->orderBy('saida.id', 'DESC')->findAll();

        //echo $saidaModel->getLastQuery();

        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();

        $data['titulo'] = 'Lista de Pagamentos de Funcionários';
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;

        echo view('pagamentoFuncionario/pagamentos_funcionarios', $data);
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

        echo view('pagamentoFuncionario/pagamento_funcionario_form', $data);
    }

    public function editar($id)
    {
        $tipoPagamentoModel = new TipoPagamentoModel();
        $saidaModel = new SaidaModel();
        $formaPagamentoModel = new FormaPagamentoModel();
        $pagamentoModel = new PagamentoModel();
        $saidaModel = new SaidaModel();
        $funcionarioModel = new FuncionarioModel();
        $tipoSaidaModel = new TipoSaidaModel();

        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['tiposSaida'] = $tipoSaidaModel->orderBy('descricao', 'ASC')->findAll();
        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();

        $data['titulo'] = 'Editar Pagamento Funcionario ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/pagamentosFuncionarios';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamento de Funcionários';

        $saida = $saidaModel->find($id);
        $funcionario = $funcionarioModel->find($saida->id_funcionario);

        if (!$saida) {
            return redirect()->to('/pagamentosFuncionarios')->with('error', 'Pagamento não encontrado.');
        }

        if ($this->request->getPost()) {

            $valor = str_replace('.', '', $this->request->getPost('valor')); // Remove os separadores de milhar
            $valor = str_replace(',', '.', $valor); // Troca a vírgula pelo ponto

            $saidaData = [
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'id_tipo_saida' => $this->request->getPost('tipoSaida'),
                'referencia' => $this->request->getPost('referencia'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'valor' => $valor,
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $saidaData = $saidaModel->update($id, $saidaData);

            if ($saidaData) {
                $data['msg'] = 'Saída atualizada com sucesso!';
            } else {
                $data['msg'] = 'Erro ao atualizar saída.';
            }

            return redirect()->to('/pagamentosFuncionarios');
        }

        $data['saida'] = $saida;
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;

        echo view('pagamentoFuncionario/pagamento_funcionario_form', $data);
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
