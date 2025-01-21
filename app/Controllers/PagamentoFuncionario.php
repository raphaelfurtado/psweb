<?php

namespace App\Controllers;

use App\Models\AnexoModel;
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

        $data['link'] = '/pagamentoFuncionario/inserir';
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
        $tipoSaidaModel = new TipoSaidaModel();
        $funcionariosModel = new FuncionarioModel();
        $anexoModel = new AnexoModel();

        $data['recebedores'] = $recebedoresModel->orderBy('nome', 'ASC')->findAll();
        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['tiposSaida'] = $tipoSaidaModel->orderBy('descricao', 'ASC')->findAll();
        $data['funcionarios'] = $funcionariosModel->orderBy('nome_completo', 'ASC')->findAll();

        $data['link'] = '/pagamentosFuncionarios';
        $data['tituloRedirect'] = 'Voltar para Lista de Saídas';
        $data['titulo'] = 'Inserir Pagamento de Funcionário';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';

        if ($this->request->getPost()) {

            $valor = str_replace('.', '', $this->request->getPost('valor')); // Remove os separadores de milhar
            $valor = str_replace(',', '.', $valor); // Troca a vírgula pelo ponto

            $saidaData = [
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'id_tipo_saida' => $this->request->getPost('tipoSaida'),
                'id_funcionario' => $this->request->getPost('funcionario'),
                'referencia' => $this->request->getPost('referencia'),
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
                        'type_anex' => 1,
                        'id_funcionario' => $this->request->getPost('funcionario'),
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
                session()->setFlashdata('msg_type', 'success');;
            } else {
                session()->setFlashdata('msg', 'Erro ao inserir dados.');
                session()->setFlashdata('msg_type', 'error');
            }

            return redirect()->to('/pagamentoFuncionario/inserir');
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
        $anexoModel = new AnexoModel();
        $tipoSaidaModel = new TipoSaidaModel();
        $funcionariosModel = new FuncionarioModel();
        $file = $this->request->getFile('file');

        $data['tiposPagamento'] = $tipoPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['formasPagamento'] = $formaPagamentoModel->orderBy('descricao', 'ASC')->findAll();
        $data['tiposSaida'] = $tipoSaidaModel->orderBy('descricao', 'ASC')->findAll();
        $data['funcionarios'] = $funcionariosModel->orderBy('nome_completo', 'ASC')->findAll();
        $totalPago = $pagamentoModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();

        $data['titulo'] = 'Editar Pagamento Funcionario ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/pagamentosFuncionarios';
        $data['tituloRedirect'] = 'Voltar para Lista de Pagamento de Funcionários';

        $saida = $saidaModel->find($id);

        if ($this->request->getPost()) {

            $anexoData = [
                'subject' => $this->request->getPost('subject'),
            ];

            $anexoModel->where('id_funcionario', $saida->id_funcionario)
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
                    'id_funcionario' => $saida->id_funcionario,
                    'subject' => $this->request->getPost('subject'),
                    'form' => 'SAIDA',
                    'identifier' => $id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // Atualizar ou inserir o registro do anexo no banco
                $anexoModel->where('id_funcionario', $saida->id_funcionario)
                    ->where('form', 'SAIDA')
                    ->where('identifier', $id)
                    ->delete(); // Remove o registro anterior, se existir

                $anexoModel->insert($anexoData);
            }

            $deleteAnexo = $this->request->getPost('delete_anexo');

            if ($deleteAnexo) {

                $anexo = $anexoModel->where('id_funcionario', $saida->id_funcionario)
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
                session()->setFlashdata('msg', 'Pagamento atualizado com sucesso!');
                session()->setFlashdata('msg_type', 'success'); // Define o tipo como sucesso
            } else {
                session()->setFlashdata('msg', 'Erro ao atualizar pagamento.');
                session()->setFlashdata('msg_type', 'error'); // Define o tipo como erro
            }
        }

        $data['saida'] = $saida;
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;
        $data['anexo'] = $anexoModel->getAnexoByFuncionarioFormIdentifier($data['saida']->id_funcionario, 'SAIDA', $id);

        echo view('pagamentoFuncionario/pagamento_funcionario_form', $data);
    }

    public function excluir($id)
    {
        $saidaModel = new SaidaModel();
        $anexoModel = new AnexoModel();

        // Verificar se o pagamento existe
        $saida = $saidaModel->find($id);

        if (!$saida) {
            return redirect()->to('/pagamentosFuncionarios')->with('msg', 'Pagamento não encontrado.')->with('msg_type', 'error');
        }

        // Excluir anexos relacionados, se existirem
        $anexos = $anexoModel->where('form', 'SAIDA')->where('identifier', $id)->findAll();

        foreach ($anexos as $anexo) {
            $filePath = WRITEPATH . 'uploads/' . $anexo['stored_name'];

            // Remover arquivo físico, se existir
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Excluir registro do anexo no banco
            $anexoModel->delete($anexo['id']);
        }

        // Excluir o pagamento
        if ($saidaModel->delete($id)) {
            return redirect()->to('/pagamentosFuncionarios')->with('msg', 'Pagamento excluído com sucesso!')->with('msg_type', 'success');
        } else {
            return redirect()->to('/pagamentosFuncionarios')->with('msg', 'Erro ao excluir pagamento.')->with('msg_type', 'error');
        }
    }
}
