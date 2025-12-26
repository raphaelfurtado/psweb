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
use CodeIgniter\I18n\Time;
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

        // Seleciona files.id como id_anexo para usar no link de download
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

            $valor = str_replace('.', '', $this->request->getPost('valor'));
            $valor = str_replace(',', '.', $valor);

            $pagadorData = [
                'id_usuario' => $this->request->getPost('morador'),
                'id_recebedor' => $this->request->getPost('recebedor'),
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'data_vencimento' => $this->request->getPost('data_vencimento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $valor,
                'situacao' => $this->request->getPost('situacao'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $pagadorID = $pagadorModel->insert($pagadorData, true);

            $files = $this->request->getFile('files');

            if ($files->isValid() && !$files->hasMoved()) {
                $mimeType = $files->getMimeType();
                $storedName = $files->getRandomName();

                // --- NOVA ESTRUTURA: Cria pasta Ano/Mes ---
                $ano = date('Y');
                $mes = date('m');
                $relativePath = $ano . '/' . $mes;
                $uploadPath = WRITEPATH . 'uploads/' . $relativePath;

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                if ($files->move($uploadPath, $storedName)) {
                    $fileSize = $files->getSize();
                    $originalName = $files->getClientName();

                    $anexoData = [
                        'original_name' => $originalName,
                        'stored_name' => $relativePath . '/' . $storedName, // Salva caminho relativo
                        'mime_type' => $mimeType,
                        'size' => $fileSize,
                        'type_anex' => 2,
                        'id_morador' => $this->request->getPost('morador'),
                        'subject' => $this->request->getPost('subject'),
                        'form' => 'PAGAMENTO',
                        'identifier' => $pagadorID,
                        'created_at' => Time::now('America/Sao_Paulo')->toDateTimeString(), // <--- CORRIGIDO
                    ];

                    $anexoModel->insert($anexoData);
                } else {
                    session()->setFlashdata('msg', 'Erro ao mover o arquivo.');
                    session()->setFlashdata('msg_type', 'error');
                }
            }

            if ($pagadorID) {
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

            $valor = str_replace('.', '', $this->request->getPost('valor'));
            $valor = str_replace(',', '.', $valor);

            $pagadorData = [
                'id_recebedor' => $this->request->getPost('recebedor'),
                'id_tipo_pagamento' => $this->request->getPost('tipoPagamento'),
                'id_forma_pagamento' => $this->request->getPost('formaPagamento'),
                'data_pagamento' => $this->request->getPost('data_pagamento'),
                'data_vencimento' => $this->request->getPost('data_vencimento'),
                'referencia' => $this->request->getPost('referencia'),
                'valor' => $valor,
                'situacao' => $this->request->getPost('situacao'),
                'observacao' => $this->request->getPost('observacao'),
                'data_insert' => date('Y-m-d H:i:s'),
            ];

            $pagadorModel->update($id, $pagadorData);

            // Atualiza assunto
            $anexoDataUpdate = [
                'subject' => $this->request->getPost('subject'),
            ];
            $anexoModel->where('id_morador', $pagamento->id_usuario)
                ->where('form', 'PAGAMENTO')
                ->where('identifier', $id)
                ->set($anexoDataUpdate)->update();

            // Lógica de UPLOAD NOVO na edição
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $mimeType = $file->getMimeType();
                $storedName = $file->getRandomName();

                // --- ESTRUTURA DE PASTAS ---
                $ano = date('Y');
                $mes = date('m');
                $relativePath = $ano . '/' . $mes;
                $uploadPath = WRITEPATH . 'uploads/' . $relativePath;

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $storedName);

                $fileSize = $file->getSize();
                $originalName = $file->getClientName();

                $anexoData = [
                    'original_name' => $originalName,
                    'stored_name' => $relativePath . '/' . $storedName,
                    'mime_type' => $mimeType,
                    'size' => $fileSize,
                    'type_anex' => 2,
                    'id_morador' => $pagamento->id_usuario,
                    'subject' => $this->request->getPost('subject'),
                    'form' => 'PAGAMENTO',
                    'identifier' => $id,
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // Remove registro anterior do banco
                $anexoModel->where('id_morador', $pagamento->id_usuario)
                    ->where('form', 'PAGAMENTO')
                    ->where('identifier', $id)
                    ->delete();

                $anexoModel->insert($anexoData);
            }

            // Lógica de DELETAR ANEXO
            $deleteAnexo = $this->request->getPost('delete_anexo');

            if ($deleteAnexo) {
                $anexo = $anexoModel->where('id_morador', $pagamento->id_usuario)
                    ->where('form', 'PAGAMENTO')
                    ->where('identifier', $id)
                    ->first();

                if ($anexo) {
                    // --- FALLBACK DE DELETE (Apaga do novo ou do antigo) ---
                    $filePath = WRITEPATH . 'uploads/' . $anexo['stored_name'];

                    if (!file_exists($filePath)) {
                        $fallbackPath = WRITEPATH . 'uploads/' . basename($anexo['stored_name']);
                        if (file_exists($fallbackPath)) {
                            $filePath = $fallbackPath;
                        }
                    }

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $anexoModel->delete($anexo['id']);
                }
            }

            if ($pagadorData) {
                session()->setFlashdata('msg', 'Pagamento atualizado com sucesso!');
                session()->setFlashdata('msg_type', 'success');
            } else {
                session()->setFlashdata('msg', 'Erro ao atualizar pagamento.');
                session()->setFlashdata('msg_type', 'error');
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

        $pagamento = $pagamentoModel->find($id);

        if (!$pagamento) {
            return redirect()->to('/pagamentos')->with('msg', 'Pagamento não encontrado.')->with('msg_type', 'error');
        }

        $anexos = $anexoModel->where('form', 'PAGAMENTO')->where('identifier', $id)->findAll();

        foreach ($anexos as $anexo) {
            // --- FALLBACK DE DELETE ---
            $filePath = WRITEPATH . 'uploads/' . $anexo['stored_name'];

            if (!file_exists($filePath)) {
                $fallbackPath = WRITEPATH . 'uploads/' . basename($anexo['stored_name']);
                if (file_exists($fallbackPath)) {
                    $filePath = $fallbackPath;
                }
            }

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $anexoModel->delete($anexo['id']);
        }

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
        $ano = $this->request->getPost('ano');
        if (!$ano) {
            return redirect()->to('/gerarPagamentos')->with('msg_alert', 'Informe o ano!');
        }
        try {
            $db = Database::connect();
            $db->query("CALL gerar_pagamentos_ano_flexivel($ano)");
            return redirect()->to('/gerarPagamentos')->with('msg_success', 'Pagamentos para o ano ' . $ano . ' gerados com sucesso.');
        } catch (DatabaseException $e) {
            return redirect()->to('/gerarPagamentos')->with('msg_error', 'Erro ao gerar pagamentos. Contate o desenvolvedor.');
        }
    }

    // --- CORREÇÃO PRINCIPAL: Recebe ID em vez do nome ---
    public function downloadPagamento($idAnexo)
    {
        $anexoModel = new AnexoModel();

        // Busca o anexo pelo ID (evita problemas de barras na URL)
        $anexo = $anexoModel->find($idAnexo);

        if (!$anexo) {
            session()->setFlashdata('msg', 'Registro do arquivo não encontrado.');
            session()->setFlashdata('msg_type', 'error');
            return redirect()->back();
        }

        // Tenta o caminho completo do banco (Ex: uploads/2026/01/foto.jpg)
        $filePath = WRITEPATH . 'uploads/' . $anexo['stored_name'];

        // --- FALLBACK: Se não achar, tenta na raiz (para arquivos antigos: uploads/foto.jpg) ---
        if (!file_exists($filePath)) {
            $onlyName = basename($anexo['stored_name']);
            $fallbackPath = WRITEPATH . 'uploads/' . $onlyName;

            if (file_exists($fallbackPath)) {
                $filePath = $fallbackPath;
            } else {
                session()->setFlashdata('msg', 'O arquivo físico não foi encontrado no servidor.');
                session()->setFlashdata('msg_type', 'error');
                return redirect()->back();
            }
        }

        $mimeType = mime_content_type($filePath);

        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $anexo['original_name'] . '"')
            ->setBody(file_get_contents($filePath));
    }
}