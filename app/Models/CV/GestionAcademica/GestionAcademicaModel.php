<?php

namespace App\Models\CV\GestionAcademica;

use CodeIgniter\Model;


class GestionAcademicaModel extends Model
{
    protected $table = 'gestion_academica';
    protected $primaryKey = 'id';
    protected $allowedFields =
        [
            'id_usuario',
            'puesto',
            'institucion',
            'mes_inicio',
            'anio_inicio',
            'mes_fin',
            'anio_fin',
            'actualmente'
        ];

    public function findGestionAcademicaById($id)
    {
        return $this->asArray()->where(['id_usuario' => $id])->findAll();
    }

}
