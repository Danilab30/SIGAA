<?php

namespace App\Models\CV\ProductoAcademico;

use CodeIgniter\Model;

class ProductoAcademicoModel extends Model
{
    protected $table = 'producto_academico';
    protected $primaryKey = 'id';

    protected $allowedFields
        = [
            "id",
            "id_usuario",
            "descripcion",
            "orden"
        ];

    public function findProductoAcademicoById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}