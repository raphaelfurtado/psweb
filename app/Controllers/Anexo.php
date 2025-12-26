<?php

namespace App\Controllers;

use App\Models\AnexoModel;
use App\Models\UserModel;

class Anexo extends BaseController
{
    public function index()
    {
        $user_id = session()->get('user_id');
        $user_role = session()->get('user_role');
        $anexoModel = new AnexoModel();

        $data['titulo'] = 'Lista de Anexos';
        $data['tituloRedirect'] = '+ Inserir Novo Anexo';
        $data['link'] = '/anexo/upload';
        $data['role'] = $user_role;
        $data['pager'] = $anexoModel->pager;

        // Query base comum
        $builder = $anexoModel->select('files.*,
                      files.id as id_anexo, 
                      files.mime_type as tipo,
                      files.subject as nome,
                      users.nome as nome_morador,
                      DATE_FORMAT(files.created_at, "%d/%m/%Y %H:%i") as created_at,
                      (CASE 
                           WHEN files.type_anex = 1 THEN "ASSOCIAÇÃO"
                           WHEN files.type_anex = 2 THEN "MORADOR"
                       END) as tipo_anexo,
                      endereco.*')
                ->join('users', 'users.id = files.id_morador', 'left')
                ->join('endereco', 'endereco.id_usuario = files.id_morador', 'left')
                ->orderBy('files.created_at', 'DESC');

        if ($user_role == 'admin') {
            $data['anexos'] = $builder->findAll();
        } else {
            $data['anexos'] = $builder->where('files.id_morador', $user_id)->findAll();
        }

        echo view('anexo/anexo_index', $data);
    }

    public function upload()
    {
        $anexoModel = new AnexoModel();
        $moradorModel = new UserModel();

        $responseMessage = '';

        if ($this->request->getPost()) {
            $files = $this->request->getFiles();
            $typeAnex = $this->request->getPost('type_anex');
            $idMorador = $this->request->getPost('id_morador');
            $subject = $this->request->getPost('subject');

            if (!empty($files['files'])) {
                foreach ($files['files'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $mimeType = $file->getMimeType();
                        $newName = $file->getRandomName(); // Nome aleatório seguro

                        // --- LÓGICA DE PASTAS (ANO/MES) ---
                        $ano = date('Y');
                        $mes = date('m');
                        
                        // Caminho relativo para salvar no Banco (ex: 2026/01)
                        $relativePath = $ano . '/' . $mes; 
                        
                        // Caminho físico completo onde o arquivo vai ficar
                        $uploadPath = WRITEPATH . 'uploads/' . $relativePath;

                        // Verifica se o diretório existe, se não, cria recursivamente
                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }

                        // Tenta mover o arquivo
                        if ($file->move($uploadPath, $newName)) {
                            $fileSize = $file->getSize();
                            $originalName = $file->getClientName();

                            $anexoData = [
                                'original_name' => $originalName,
                                // Salva o caminho relativo + nome (ex: 2026/01/x8s7...png)
                                'stored_name' => $relativePath . '/' . $newName,
                                'mime_type' => $mimeType,
                                'size' => $fileSize,
                                'type_anex' => $typeAnex,
                                'id_morador' => $idMorador,
                                'subject' => $subject,
                                'created_at' => date('Y-m-d H:i:s'),
                                'form' => 'ANEXO'
                            ];

                            $anexoModel->insert($anexoData);
                            return redirect()->to('/anexos')->with('msg_success', 'Arquivo Salvo com Sucesso.');
                        } else {
                            $responseMessage = 'Erro ao mover o arquivo para o diretório de uploads.';
                        }
                    } else {
                        $responseMessage = 'Arquivo inválido ou já movido.';
                    }
                }
            } else {
                $responseMessage = 'Nenhum arquivo selecionado.';
            }
        }

        $data['moradores'] = $moradorModel->orderBy('nome', 'ASC')->findAll();
        $data['link'] = '/anexos';
        $data['tituloRedirect'] = 'Voltar para Lista de Anexos';
        $data['titulo'] = 'Upload de Arquivos';
        $data['acao'] = 'Inserir';
        $data['msg'] = $responseMessage;
        $data['tipos'] = $anexoModel->getParametroDetalhesByMnemonico('TPANEX');

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        return view('anexo/anexo_form', $data);
    }

    // ALTERADO: Recebe o ID em vez do nome do arquivo
    public function download($id)
    {
        $anexoModel = new AnexoModel();
        $arquivo = $anexoModel->find($id);

        if (!$arquivo) {
            return redirect()->to('/anexos')->with('msg_error', 'Registro do arquivo não encontrado.');
        }

        // Tenta o caminho exato salvo no banco (serve para os novos e antigos se estiverem corretos)
        $fullPath = WRITEPATH . 'uploads/' . $arquivo['stored_name'];

        // --- LÓGICA DE SEGURANÇA (FALLBACK) ---
        // Se o arquivo não existir no caminho indicado, verifica se está solto na raiz 'uploads'
        if (!file_exists($fullPath)) {
            // Pega apenas o nome do arquivo (remove pastas se houver)
            $onlyName = basename($arquivo['stored_name']);
            $fallbackPath = WRITEPATH . 'uploads/' . $onlyName;

            if (file_exists($fallbackPath)) {
                $fullPath = $fallbackPath;
            } else {
                // Se não achar nem na pasta específica nem na raiz
                return redirect()->to('/anexos')->with('msg_error', 'O arquivo físico não foi encontrado no servidor.');
            }
        }

        // Se chegou aqui, o $fullPath é válido
        $mimeType = mime_content_type($fullPath);

        return $this->response
            ->setHeader('Content-Type', $mimeType)
            ->setHeader('Content-Disposition', 'inline; filename="' . $arquivo['original_name'] . '"')
            ->setBody(file_get_contents($fullPath));
    }

    public function deletar($id)
    {
        $anexoModel = new AnexoModel();
        $anexo = $anexoModel->find($id);

        if (!$anexo) {
            return redirect()->to('/anexos')->with('msg_error', 'Arquivo não encontrado.');
        }

        // Caminho padrão (baseado no banco)
        $fullPath = WRITEPATH . 'uploads/' . $anexo['stored_name'];

        // --- LÓGICA DE SEGURANÇA ---
        if (!file_exists($fullPath)) {
            // Tenta achar na raiz caso seja um arquivo antigo
            $onlyName = basename($anexo['stored_name']);
            $fallbackPath = WRITEPATH . 'uploads/' . $onlyName;

            if (file_exists($fallbackPath)) {
                $fullPath = $fallbackPath;
            }
        }

        // Se o arquivo existe (seja na pasta nova ou na raiz), apaga.
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
        
        // Remove do banco de dados
        $anexoModel->delete($id);
        
        return redirect()->to('/anexos')->with('msg_success', 'Arquivo deletado com sucesso.');
    }
}