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

    public function getAnexoByFuncionarioFormIdentifier($id_funcionario, $form, $identifier)
    {
        return $this->where('id_funcionario', $id_funcionario)
            ->where('form', $form)
            ->where('identifier', $identifier)
            ->first();
        //->findAll();
    }
}
