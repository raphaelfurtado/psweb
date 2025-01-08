<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EnderecoModel;
use App\Models\PagamentoModel;
use CodeIgniter\Config\Services;
use Config\Database;

class User extends BaseController
{

    public function index()
    {
        $userModel = new UserModel();

        $nome = $this->request->getGet('nome');

        // Realiza o JOIN com a tabela de endereços
        $query = $userModel
            ->select('users.*, users.id as id_user, endereco.*')
            ->join('endereco', 'endereco.id_usuario = users.id', 'left'); // LEFT JOIN para incluir usuários sem endereço

        if (!empty($nome)) {
            $query->like('usuarios.nome', $nome);
        }

        $data['moradores'] = $query->findAll();
        $data['titulo'] = 'Lista de moradores';
        $data['link'] = '/user/inserir';
        $data['tituloRedirect'] = '+ Inserir Novo Usuário';
        $data['nome'] = $nome ?? '';

        echo view('moradores', $data);
    }



    public function inserir()
    {
        $data['titulo'] = 'Inserir novo usuário';
        $data['acao'] = 'Inserir';
        $data['msg'] = '';
        $data['link'] = '/users';
        $data['tituloRedirect'] = 'Voltar para Lista de Usuários';

        if ($this->request->getPost()) {
            $validation = Services::validation();

            $validation->setRules([
                //     'nome' => 'required|min_length[3]|max_length[50]',
                'telefone' => 'required|numeric|is_unique[users.telefone]',
                //     'senha' => 'permit_empty|min_length[6]',
                //     'rua' => 'required|max_length[15]',
                //'numero' => 'required|is_unique[endereco.numero]',
                //     'quadra' => 'required',
                //     'qtd_lote' => 'required|numeric',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $data['msg'] = ['type' => 'error', 'text' => 'Erro de validação: ' . implode(', ', $validation->getErrors())];
                return view('user_form', $data);
            }

            // $db = Database::connect();
            // $db->transStart();

            $userModel = new UserModel();
            $enderecoModel = new EnderecoModel();

            $userData = [
                'nome' => $this->request->getPost('nome'),
                'aniversario' => $this->request->getPost('aniversario'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
                'senha' => $this->request->getPost('senha') ? password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT) : null,
                'role' => 'user', // ou 'admin'
            ];

            $userId = $userModel->insert($userData, true); // `true` retorna o ID do registro inserido

            if ($userId) {
                $enderecoData = [
                    'id_usuario' => $userId, // Relaciona o endereço ao usuário
                    'rua' => $this->request->getPost('rua'),
                    'numero' => $this->request->getPost('numero'),
                    'quadra' => $this->request->getPost('quadra'),
                    'qtd_lote' => $this->request->getPost('qtd_lote'),
                    'data_insert' => date('Y-m-d H:i:s'),
                ];

                if ($enderecoModel->insert($enderecoData)) {
                    $data['msg'] = ['type' => 'success', 'text' => 'Usuário e endereço inseridos com sucesso!'];
                } else {
                    $data['msg'] = ['type' => 'error', 'text' => 'Usuário inserido, mas ocorreu um erro ao salvar o endereço.'];
                }
            } else {
                $data['msg'] = ['type' => 'error', 'text' => 'Erro ao inserir usuário.'];
            }
        }

        echo view('user_form', $data);
    }

    public function editar($id)
    {
        $userModel = new UserModel();
        $enderecoModel = new EnderecoModel();

        // Buscar usuário e endereço
        $usuario = $userModel->find($id);
        $endereco = $enderecoModel->getEnderecoByUsuarioId($id);

        if (!$usuario) {
            return redirect()->to('/users')->with('error', 'Usuário não encontrado.');
        }

        // Obter pagamentos do usuário
        $pagamentos = $this->getPagamentosPorUsuario($id);

        if ($this->request->getPost()) {
            // Validar os dados recebidos
            // $validation = \Config\Services::validation();
            // $validation->setRules([
            //     'nome' => 'required|min_length[3]',
            //     'aniversario' => 'required|valid_date',
            //     'telefone' => 'required',
            //     'rua' => 'required',
            //     'numero' => 'required',
            //     'qtd_lote' => 'required',
            // ]);

            // if (!$validation->withRequest($this->request)->run()) {
            //     return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            // }

            // Atualizar endereço

            $enderecoData = [
                'rua' => $this->request->getPost('rua'),
                'numero' => $this->request->getPost('numero'),
                'quadra' => $this->request->getPost('quadra'),
                'qtd_lote' => $this->request->getPost('qtd_lote'),
            ];

            $enderecoModel->where('id_usuario', $id)->set([
                'rua' => $this->request->getPost('rua'),
                'numero' => $this->request->getPost('numero'),
                'quadra' => $this->request->getPost('quadra'),
                'qtd_lote' => $this->request->getPost('qtd_lote'),
            ])->update();

            // Atualizar usuário
            $userData = [
                'nome' => $this->request->getPost('nome'),
                'aniversario' => $this->request->getPost('aniversario'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
                //'senha' => $this->request->getPost('senha') ? password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT) : null,
                //'role' => 'user', // ou 'admin'
            ];

            if ($this->request->getPost('senha')) {
                $userData['senha'] = password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT);
            }


            if ($userModel->update($id, $userData)) {
                session()->setFlashdata('msg', 'Dados atualizado com sucesso!');
                session()->setFlashdata('msg_type', 'success');
            } else {
                session()->setFlashdata('msg', 'Erro ao atualizar dados.');
                session()->setFlashdata('msg_type', 'error');
            }

            return redirect()->to('/user/inserir');
        }

        // Dados para a visualização
        $data = [
            'titulo' => 'Editar usuário ' . $id,
            'acao' => 'Atualizar',
            'msg' => '',
            'link' => '/users',
            'tituloRedirect' => 'Voltar para Lista de Usuários',
            'usuario' => $usuario,
            'endereco' => $endereco,
            'pagamentos' => $pagamentos['data'],
        ];

        return view('user_form', $data);
    }

    private function getPagamentosPorUsuario($idUsuario)
    {
        $pagadorModel = new PagamentoModel();

        $pagamentos = $pagadorModel
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
            ->join('tipo_pagamento', 'tipo_pagamento.codigo = pagamento.id_tipo_pagamento')
            ->where('pagamento.id_usuario', $idUsuario)
            ->orderBy('pagamento.id', 'DESC')
            ->findAll();

        //echo $pagadorModel->getLastQuery();

        return [
            'data' => $pagamentos,
        ];
    }

    public function lista()
    {
        $moradorModel = new UserModel();

        $nome = $this->request->getGet('nome');

        $query = $moradorModel->select('id, nome');

        if (!empty($nome)) {
            $query->like('nome', $nome);
        }

        $moradores = $query->paginate(10);
        $pager = $moradorModel->pager;

        $data = [
            'titulo' => 'Lista de Moradores',
            'moradores' => $moradores,
            'pager' => $pager,
            'nome' => $nome ?? '', // Passar o termo de pesquisa (ou vazio se não existir)
        ];

        echo view('lista_moradores', $data);
    }
}
