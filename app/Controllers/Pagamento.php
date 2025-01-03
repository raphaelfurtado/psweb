<?php

namespace App\Controllers;

use App\Models\FormaPagamentoModel;
use App\Models\PagamentoModel;
use App\Models\RecebedorModel;
use App\Models\TipoPagamentoModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Config\Database;

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
            ->join('endereco', 'endereco.id_usuario = users.id', 'left')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->orderBy('pagamento.id', 'DESC')->findAll();

        //echo $pagadorModel->getLastQuery();

        $data['titulo'] = 'Lista de Pagamento';

        echo view('pagamentos', $data);
    }

    public function inserir()
    {
        $recebedoresModel = new RecebedorModel();
        $moradorModel = new UserModel();
        $tipoPagamentoModel = new TipoPagamentoModel();
        $formaPagamentoModel = new FormaPagamentoModel();
        $db = Database::connect();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['moradores'] = $moradorModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();

        $data['link'] = '/pagamentos';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamentos';
        $data['titulo'] = 'Inserir Pagador';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

        $query = $db->query("SHOW COLUMNS FROM pagamento LIKE 'situacao'");
        $row = $query->getRow();
        preg_match("/^enum\('(.*)'\)$/", $row->Type, $matches);

        if ($this->request->getPost()) {
            $pagadorModel = new PagamentoModel();

            $pagadorData = [
                'id_usuario' => $this->request->getPost('morador'),
                'id_recebedor' => $this->request->getPost('recebedor'),
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $this->request->getPost('valor'),
                'situacao' => $this->request->getPost('situacao'),
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
        $data['situacoes'] = explode("','", $matches[1]);

        echo view('pagamento_form', $data);
    }

    public function editar($id)
    {
        $recebedoresModel = new RecebedorModel();
        $moradorModel = new UserModel();
        $tipoPagamentoModel = new TipoPagamentoModel();
        $pagadorModel = new PagamentoModel();
        $formaPagamentoModel = new FormaPagamentoModel();
        $db = Database::connect();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['moradores'] = $moradorModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();

        $data['titulo'] = 'Editar Pagamento ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/pagamentos';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamentos';

        $query = $db->query("SHOW COLUMNS FROM pagamento LIKE 'situacao'");
        $row = $query->getRow();
        preg_match("/^enum\('(.*)'\)$/", $row->Type, $matches);

        $pagamento = $pagadorModel->find($id);

        if (!$pagamento) {
            return redirect()->to('/users')->with('error', 'Pagamento não encontrado.');
        }

        if ($this->request->getPost()) {
            $pagadorModel = new PagamentoModel();

            $pagadorData = [
                'id_recebedor' => $this->request->getPost('recebedor'),
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $this->request->getPost('valor'),
                'situacao' => $this->request->getPost('situacao'),
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

        $data['situacoes'] = explode("','", $matches[1]);
        $data['pagamento'] = $pagamento;

        echo view('pagamento_form', $data);
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
