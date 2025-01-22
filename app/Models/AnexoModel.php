<?php

namespace App\Models;

use CodeIgniter\Model;

class AnexoModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $allowedFields = ['original_name', 'stored_name', 'mime_type', 'size', 'type_anex', 'id_morador', 'id_funcionario', 'subject', 'form', 'identifier', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    public function getAnexoByMoradorFormIdentifier($id_morador, $form, $identifier)
    {
        return $this->where('id_morador', $id_morador)
            ->where('form', $form)
            ->where('identifier', $identifier)
            ->first();
        //->findAll();
    }


    public function getParametroDetalhesByMnemonico($mnemonico)
    {
        $query = $this->db->table('parametro_detalhe')
            ->select('codigo, descricao')
            ->where('mnemonico_mestre', $mnemonico)
            ->where('registro_ativo', 1)
            ->get();

        return $query->getResult();
    }

    public function getDocPrestacaoContas()
    {
        $query = $this->db->table('files')
            ->select('files.*,
                              DATE_FORMAT(files.created_at, "%d/%m/%Y") as created_at')
            ->where('type_anex', 3)
            ->get();

        return $query->getResult();
    }
    public function getAnexoByFuncionarioFormIdentifier($id_funcionario, $form, $identifier)
    {
        return $this->where('id_funcionario', $id_funcionario)
            ->where('form', $form)
            ->where('identifier', $identifier)
            ->first();
        //->findAll();
    }
}
