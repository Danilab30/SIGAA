<?php

namespace App\Models\CV\DisenoIngenieril;

use CodeIgniter\Model;

class DisenoIngenierilModel extends Model
{
    protected $table = 'diseno_ingenieril';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_usuario',
        'organismo',
        'anio_inicio',
        'anio_fin',
        'nivel_experiencia',
        'otro_nivel'
    ];

    public function FindDisenoIngenierilById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }



}