<?php

namespace App\Models\CV\AportacionPE;

use CodeIgniter\Model;

class AportacionPEModel extends Model
{
    protected $table = 'aportacion_pe';
    protected $primaryKey = 'id';

    protected $allowedFields
        = [
            "id",
            "id_usuario",
            "descripcion"
        ];

    public function findAportacionPEById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}