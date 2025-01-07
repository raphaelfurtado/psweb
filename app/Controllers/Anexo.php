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
        if ($user_role == 'admin') {
            $data['anexos'] = $anexoModel
                ->select('files.*,
                      files.id as id_anexo, 
                      files.mime_type as tipo,
                      files.subject as nome,
                      users.nome as nome_morador,
                      DATE_FORMAT(files.created_at, "%d/%m/%Y %H:%i") as created_at,
                      (CASE 
                           WHEN files.type_anex = 1 THEN "ASSOCIAÇÃO"
                           WHEN files.type_anex = 2 THEN "MORADOR"
                       END) as tipo_anexo,
                      endereco.*
                     ')
                ->join('users', 'users.id = files.id_morador', 'left')
                ->join('endereco', 'endereco.id_usuario = files.id_morador', 'left')
                ->orderBy('files.created_at', 'DESC')
                ->paginate(10);
        } else {
            $data['anexos'] = $anexoModel
                ->select('files.*, 
              files.id as id_anexo, 
              files.mime_type as tipo,
              files.subject as nome,
              users.nome as nome_morador,
              DATE_FORMAT(files.created_at, "%d/%m/%Y %H:%i") as created_at,
              (CASE 
                   WHEN files.type_anex = 1 THEN "ASSOCIAÇÃO"
                   WHEN files.type_anex = 2 THEN "MORADOR"
               END) as tipo_anexo,
              endereco.*
             ')
                ->join('users', 'users.id = files.id_morador', 'left')
                ->join('endereco', 'endereco.id_usuario = files.id_morador', 'left')
                ->where('files.id_morador', $user_id)
                ->orderBy('files.created_at', 'DESC')
                ->paginate(10);
        }

        // var_dump($data);
        // die();
        // echo view('anexos', $data);

        echo view('anexo_index', $data);
    }

    public function upload()
    {
        $anexoModel = new AnexoModel();
        $moradorModel = new UserModel();

        // Inicialize a variável $responseMessage com uma mensagem padrão
        $responseMessage = '';

        // Verifica se é uma requisição POST
        if ($this->request->getPost()) {
            $files = $this->request->getFiles();
            $typeAnex = $this->request->getPost('type_anex');
            $idMorador = $this->request->getPost('id_morador');
            $subject = $this->request->getPost('subject');

            // Valida se arquivos foram enviados
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
                                'type_anex' => $typeAnex,
                                'id_morador' => $idMorador,
                                'subject' => $subject,
                                'created_at' => date('Y-m-d H:i:s'),
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

        // Preparando os dados para enviar para a view
        $data['moradores'] = $moradorModel->orderBy('nome', 'ASC')->findAll();
        $data['link'] = '/anexos';
        $data['tituloRedirect'] = 'Voltar para Lista de Anexos';
        $data['titulo'] = 'Upload de Arquivos';
        $data['acao'] = 'Inserir';
        $data['msg'] = $responseMessage;

        // Se for uma requisição AJAX, retorna os dados em formato JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        // Se não for AJAX, renderiza a view normalmente
        return view('anexo_form', $data);
    }

    public function download($filename)
    {
        $filePath = WRITEPATH . 'uploads/' . $filename;
        if (file_exists($filePath)) {
            return $this->response->download($filePath, null);
        }
        return redirect()->to('/anexos')->with('msg_error', 'O arquivo solicitado não foi encontrado.');
    }

    public function deletar($id)
    {
        $anexoModel = new AnexoModel();
        $anexo = $anexoModel->find($id);

        if (!$anexo) {
            return redirect()->to('/anexos')->with('msg_error', 'Arquivo não encontrado.');
        }

        $filePath = WRITEPATH . 'uploads/' . $anexo['stored_name'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $anexoModel->delete($id);
        return redirect()->to('/anexos')->with('msg_success', 'Arquivo deletado com sucesso.');
    }

}