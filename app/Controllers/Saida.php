<?php

namespace App\Controllers;

use App\Models\AnexoModel;
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
            ->where('id_funcionario', null)
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
        $anexoModel = new AnexoModel();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();

        $data['link'] = '/saidas';
        $data['tituloRedirect'] = 'Voltar para Lista de Saídas';
        $data['titulo'] = 'Inserir Saída';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

        if ($this->request->getPost()) {

            $valor = str_replace('.', '', $this->request->getPost('valor')); // Remove os separadores de milhar
            $valor = str_replace(',', '.', $valor); // Troca a vírgula pelo ponto

            $saidaData = [
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'valor' => $valor,
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $saidaData = $saidaModel->insert($saidaData, true);

            $file = $this->request->getFile('file');

            if ($file->isValid() && !$file->hasMoved()) {
                $mimeType = $file->getMimeType();
                $storedName = $file->getRandomName();

                if ($file->move(WRITEPATH . 'uploads', $storedName)) {
                    $fileSize = $file->getSize();
                    $originalName = $file->getClientName();

                    $anexoData = [
                        'original_name' => $originalName,
                        'stored_name' => $storedName,
                        'mime_type' => $mimeType,
                        'size' => $fileSize,
                        'type_anex' => 1, // ASSOCIAÇÃO
                        'subject' => $this->request->getPost('subject'),
                        'form' => 'SAIDA',
                        'identifier' => $saidaData,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];

                    $anexoModel->insert($anexoData);
                } else {
                    session()->setFlashdata('msg', 'Erro ao mover o arquivo.');
                    session()->setFlashdata('msg_type', 'error');
                }
            } else {
                session()->setFlashdata('msg', 'Arquivo inválido ou já movido.');
                session()->setFlashdata('msg_type', 'error');
            }

            if ($saidaData) {
                session()->setFlashdata('msg', 'Dados inseridos com sucesso!');
                session()->setFlashdata('msg_type', 'success');
            } else {
                session()->setFlashdata('msg', 'Erro ao inserir pagamento.');
                session()->setFlashdata('msg_type', 'error');
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
        $anexoModel = new AnexoModel();

        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();
        $file = $this->request->getFile('file');

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

            $anexoData = [
                'subject' => $this->request->getPost('subject'),
            ];

            $anexoModel->where('id_funcionario', null)
                ->where('form', 'SAIDA')
                ->where('identifier', $id)
                ->set($anexoData)->update();

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $mimeType = $file->getMimeType();
                $storedName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/', $storedName);

                $fileSize = $file->getSize();
                $originalName = $file->getClientName();

                $anexoData = [
                    'original_name' => $originalName,
                    'stored_name' => $storedName,
                    'mime_type' => $mimeType,
                    'size' => $fileSize,
                    'type_anex' => 1, // ASSOCIAÇÃO 
                    'subject' => $this->request->getPost('subject'),
                    'form' => 'SAIDA',
                    'identifier' => $id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // Atualizar ou inserir o registro do anexo no banco
                $anexoModel->where('id_funcionario', null)
                    ->where('form', 'SAIDA')
                    ->where('identifier', $id)
                    ->delete(); // Remove o registro anterior, se existir

                $anexoModel->insert($anexoData);
            }

            $deleteAnexo = $this->request->getPost('delete_anexo');

            if ($deleteAnexo) {

                $anexo = $anexoModel->where('id_funcionario', null)
                    ->where('form', 'SAIDA')
                    ->where('identifier', $id)
                    ->first();

                if ($anexo) {
                    // Remover o arquivo físico
                    $filePath = WRITEPATH . 'uploads/' . $anexo['stored_name'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Excluir o registro do banco de dados
                    $anexoModel->delete($anexo['id']);
                }
            }

            if (!$saida) {
                return redirect()->to('/pagamentosFuncionarios')->with('error', 'Pagamento não encontrado.');
            }

            $valor = str_replace('.', '', $this->request->getPost('valor')); // Remove os separadores de milhar
            $valor = str_replace(',', '.', $valor);

            $saidaData = [
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'valor' => $valor,
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $saidaData = $saidaModel->update($id, $saidaData);

            if ($saidaData) {
                session()->setFlashdata('msg', 'Dados atualizados com sucesso!');
                session()->setFlashdata('msg_type', 'success');
            } else {
                session()->setFlashdata('msg', 'Erro ao atualizar saída pagamento.');
                session()->setFlashdata('msg_type', 'error');
            }
        }

        $data['saida'] = $saida;
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;
        $data['anexo'] = $anexoModel->getAnexoByFuncionarioFormIdentifier(null, 'SAIDA', $id);

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
