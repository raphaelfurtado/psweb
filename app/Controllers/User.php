<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EnderecoModel;
use App\Models\PagamentoModel;

class User extends BaseController
{

    public function index()
    {
        $userModel = new UserModel();

        // Obter o termo de pesquisa do GET
        $nome = $this->request->getGet('nome');

        // Query base
        $query = $userModel->select('id, nome');

        // Aplicar filtro, se o nome for informado
        if (!empty($nome)) {
            $query->like('nome', $nome);
        }

        // Obter os resultados
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
            $userModel = new UserModel();
            $enderecoModel = new EnderecoModel();

            $userData = [
                'nome' => $this->request->getPost('nome'),
                'aniversario' => $this->request->getPost('aniversario'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
                'senha' => password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT),
                'role' => 'user', // ou 'admin'
            ];

            $userId = $userModel->insert($userData, true); // `true` retorna o ID do registro inserido

            if ($userId) {
                $enderecoData = [
                    'id_usuario' => $userId, // Relaciona o endereço ao usuário
                    'rua' => $this->request->getPost('rua'),
                    'numero' => $this->request->getPost('numero'),
                    'quadra' => $this->request->getPost('quadra'),
                    'data_insert' => date('Y-m-d H:i:s'),
                ];

                if ($enderecoModel->insert($enderecoData)) {
                    $data['msg'] = 'Usuário e endereço inseridos com sucesso!';
                } else {
                    $data['msg'] = 'Usuário inserido, mas ocorreu um erro ao salvar o endereço.';
                }
            } else {
                $data['msg'] = 'Erro ao inserir usuário.';
            }
        }

        echo view('user_form', $data);
    }

    public function editar($id)
    {

        $data['titulo'] = 'Editar usuário ' . $id;
        $data['acao'] = 'Atualizar';
        $data['msg'] = '';
        $data['link'] = '/users';
        $data['tituloRedirect'] = 'Voltar para Lista de Usuários';

        $userModel = new UserModel();
        $enderecoModel = new EnderecoModel();
        $pagadorModel = new PagamentoModel();

        $usuario = $userModel->find($id);
        $endereco = $enderecoModel->getEnderecoByUsuarioId($id);

        if (!$usuario) {
            return redirect()->to('/users')->with('error', 'Usuário não encontrado.');
        }

        // Obter pagamentos do usuário
        $pagamentos = $this->getPagamentosPorUsuario($id);

        if ($this->request->getPost()) {

            $enderecoModel->where('id_usuario', $id)->set([
                'rua' => $this->request->getPost('rua'),
                'numero' => $this->request->getPost('numero'),
                'quadra' => $this->request->getPost('quadra'),
            ])->update();

            if ($userModel->update($id, [
                'nome' => $this->request->getPost('nome'),
                'aniversario' => $this->request->getPost('aniversario'),
                'telefone' => $this->request->getPost('telefone'),
                'telefone_2' => $this->request->getPost('telefone_2'),
                'senha' => password_hash($this->request->getPost('senha'), PASSWORD_DEFAULT),
                'role' => 'user', // ou 'admin'
            ])) {
                $data['msg'] = 'Usuário e endereço atualizados com sucesso!';
            } else {
                $data['msg'] = 'Erro ao atualizar o endereço.';
            };

            return redirect()->to('/users');
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
            'pager' => $pagamentos['pager'],
        ];

        echo view('user_form', $data);
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
            ->join('tipo_pagamento', 'tipo_pagamento.id = pagamento.id_tipo_pagamento')
            ->where('pagamento.id_usuario', $idUsuario)
            ->orderBy('pagamento.id', 'DESC')
            ->paginate(10);

        return [
            'data' => $pagamentos,
            'pager' => $pagadorModel->pager,
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
