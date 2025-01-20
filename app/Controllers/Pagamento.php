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

class Pagamento extends BaseController
{

    public function index()
    {
        $pagadorModel = new PagamentoModel();
        $saidaModel = new SaidaModel();

        $totalPago = $pagadorModel->getTotalPago();
        $totalSaida = $saidaModel->getTotalSaida();


        $data['link'] = 'pagamento/inserir';
        $data['tituloRedirect'] = '+ Inserir Novo Pagamento';
        $data['pagamentos'] = $pagadorModel
            ->select('pagamento.*, 
                pagamento.id as id_pagamento,
                users.nome as nome_morador, 
                recebedor.nome as nome_recebedor, 
                endereco.*,
                tipo_pagamento.descricao as desc_pagamento,
                forma_pagamento.descricao as desc_forma_pagto,
                files.id as id_anexo,
                files.stored_name as stored_name
              ')
            ->join('users', 'users.id = pagamento.id_usuario')
            ->join('recebedor', 'recebedor.id = pagamento.id_recebedor', 'left')
            ->join('endereco', 'endereco.id_usuario = users.id', 'left')
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->join('forma_pagamento', 'forma_pagamento.codigo = pagamento.id_forma_pagamento', 'left')
            ->join('files', 'files.id_morador = pagamento.id_usuario AND files.identifier = pagamento.id AND files.form = "PAGAMENTO"', 'left')
            ->orderBy('pagamento.data_pagamento, users.nome', 'ASC')->findAll();

        //echo $pagadorModel->getLastQuery();
        $data['totalPago'] = $totalPago->total ?? 0;
        $data['totalSaida'] = $totalSaida->total ?? 0;
        $data['titulo'] = 'Pagamentos Cadastrados';

        echo view('pagamentos', $data);
    }

    public function inserir()
    {
        $recebedoresModel = new RecebedorModel();
        $moradorModel = new UserModel();
        $tipoPagamentoModel = new TipoPagamentoModel();
        $formaPagamentoModel = new FormaPagamentoModel();
        $anexoModel = new AnexoModel();
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
                'data_vencimento' => $this->request->getPost('data_vencimento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $this->request->getPost('valor'),
                'situacao' => $this->request->getPost('situacao'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $pagadorData = $pagadorModel->insert($pagadorData, true);

            $files = $this->request->getFiles();

            if (!empty($files['files'])) {
                foreach ($files['files'] as $file) {
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
                                'type_anex' => 2, // MORADOR - Sempre vai ser morador quando for Pagamento
                                'id_morador' => $this->request->getPost('morador'),
                                'subject' => $this->request->getPost('subject'),
                                'form' => 'PAGAMENTO',
                                'identifier' => $pagadorData,
                                'created_at' => date('Y-m-d H:i:s'),
                            ];

                            $anexoModel->insert($anexoData);
                            //return redirect()->to('/anexos')->with('msg_success', 'Arquivo Salvo com Sucesso.');
                        } else {
                            session()->setFlashdata('msg', 'Erro ao inserir anexo.');
                            session()->setFlashdata('msg_type', 'error');
                        }
                    } else {
                        session()->setFlashdata('msg', 'Arquivo inválido ou já movido.');
                        session()->setFlashdata('msg_type', 'error');
                    }
                }
            }

            if ($pagadorData) {
                session()->setFlashdata('msg', 'Dados inseridos com sucesso!');
                session()->setFlashdata('msg_type', 'success');
            } else {
                session()->setFlashdata('msg', 'Erro ao inserir dados.');
                session()->setFlashdata('msg_type', 'error');
            }

            return redirect()->to('/pagamento/inserir');
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
        $anexoModel = new AnexoModel();
        $file = $this->request->getFile('files');
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
                'data_vencimento' => $this->request->getPost('data_vencimento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $this->request->getPost('valor'),
                'situacao' => $this->request->getPost('situacao'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $pagadorData = $pagadorModel->update($id, $pagadorData);

            $anexoData = [
                'subject' => $this->request->getPost('subject'),
            ];

            $anexoModel->where('id_morador', $pagamento->id_usuario)
                ->where('form', 'PAGAMENTO')
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
                    'type_anex' => 2, // MORADOR - Sempre vai ser morador quando for Pagamento
                    'id_morador' => $pagamento->id_usuario,
                    'subject' => $this->request->getPost('subject'),
                    'form' => 'PAGAMENTO',
                    'identifier' => $id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // Atualizar ou inserir o registro do anexo no banco
                $anexoModel->where('id_morador', $pagamento->id_usuario)
                    ->where('form', 'PAGAMENTO')
                    ->where('identifier', $id)
                    ->delete(); // Remove o registro anterior, se existir

                $anexoModel->insert($anexoData);
            }

            $deleteAnexo = $this->request->getPost('delete_anexo');

            if ($deleteAnexo) {

                $anexo = $anexoModel->where('id_morador', $pagamento->id_usuario)
                    ->where('form', 'PAGAMENTO')
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

            if ($pagadorData) {
                session()->setFlashdata('msg', 'Pagamento atualizado com sucesso!');
                session()->setFlashdata('msg_type', 'success'); // Define o tipo como sucesso
            } else {
                session()->setFlashdata('msg', 'Erro ao atualizar pagamento.');
                session()->setFlashdata('msg_type', 'error'); // Define o tipo como erro
            }
        }

        $data['pagamento'] = $pagadorModel->find($id);
        $data['anexo'] = $anexoModel->getAnexoByMoradorFormIdentifier($data['pagamento']->id_usuario, 'PAGAMENTO', $id);
        $data['situacoes'] = explode("','", $matches[1]);

        echo view('pagamento_form', $data);
    }

    public function excluir($id)
    {
        $pagamentoModel = new PagamentoModel();
        $anexoModel = new AnexoModel();

        // Verificar se o pagamento existe
        $pagamento = $pagamentoModel->find($id);

        if (!$pagamento) {
            return redirect()->to('/pagamentos')->with('msg', 'Pagamento não encontrado.')->with('msg_type', 'error');
        }

        // Excluir anexos relacionados, se existirem
        $anexos = $anexoModel->where('form', 'PAGAMENTO')->where('identifier', $id)->findAll();

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
        if ($pagamentoModel->delete($id)) {
            return redirect()->to('/pagamentos')->with('msg', 'Pagamento excluído com sucesso!')->with('msg_type', 'success');
        } else {
            return redirect()->to('/pagamentos')->with('msg', 'Erro ao excluir pagamento.')->with('msg_type', 'error');
        }
    }


    public function gerarPagamentosForm()
    {

        $data['link'] = '/pagamentos';
        $data['titulo'] = 'Gerar Pagamentos';
        $data['acao'] = 'Gerar';

        return view('pagamento/gerar_pagamentos', $data);
    }

    public function gerarPagamentos()
    {
        // Recupera o ano do formulário
        $ano = $this->request->getPost('ano');
        if (!$ano) {
            return redirect()->to('/gerarPagamentos')->with('msg_alert', 'Informe o ano!');
        }
        try {
            // Executa a procedure no banco de dados
            $db = Database::connect();
            $db->query("CALL gerar_pagamentos_ano_flexivel($ano)");
            // Retorno de sucesso
            return redirect()->to('/gerarPagamentos')->with('msg_success', 'Pagamentos para o ano ' . $ano . ' gerados com sucesso.');
        } catch (DatabaseException $e) {
            // Caso ocorra algum erro na execução da procedure
            return redirect()->to('/gerarPagamentos')->with('msg_error', 'Erro ao gerar pagamentos. Contate o desenvolvedor.');
        }
    }

    public function downloadPagamento($storedName)
    {
        // Caminho completo do arquivo
        $filePath = WRITEPATH . 'uploads/' . $storedName;

        // Verifica se o arquivo existe
        if (!file_exists($filePath)) {
            // Define a mensagem de erro e redireciona
            session()->setFlashdata('msg', 'O arquivo solicitado não foi encontrado. Verifique e tente novamente.');
            session()->setFlashdata('msg_type', 'error'); // Define o tipo de mensagem como erro

            return redirect()->back(); // Retorna para a página anterior
        }

        // Determina o tipo MIME do arquivo
        $mimeType = mime_content_type($filePath);

        // Retorna o arquivo como resposta para visualização no navegador
        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . basename($storedName) . '"')
            ->setBody(file_get_contents($filePath));
    }
}
