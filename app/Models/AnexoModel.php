<?php

namespace App\Models;

use CodeIgniter\Model;

class AnexoModel extends Model
{
    protected $table = 'files';
    protected $primaryKey = 'id';
    protected $allowedFields = ['original_name', 'stored_name', 'mime_type', 'size', 'type_anex', 'id_morador', 'subject', 'form', 'identifier', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
}
