<?php namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table      = 'roles';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nombre', 'descripcion']; // Campos permitidos

    // Puedes añadir una función para buscar el nombre por ID
    public function getRolName($id)
    {
        return $this->select('nombre')
                    ->find($id)['nombre'] ?? null;
    }
}