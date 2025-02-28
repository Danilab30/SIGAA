<?php

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\GestionAcademica\GestionAcademicaModel;
use App\Models\UsuarioModel;

class GestionAcademica extends BaseController{

private $GestionAcademicaModel;
private $UsuarioModel;


public function __construct()
{
    $this->GestionAcademicaModel = new GestionAcademicaModel();
    $this->UsuarioModel = new UsuarioModel();

}


public function index()
{
    $id = session()->get('id');

    if (empty($id)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
    }

    if(isset($_SESSION['id'])){
        $id_usuario = $_SESSION['id'];
        $gestiones = $this->GestionAcademicaModel->where('id_usuario', $id_usuario)->findAll();
        $data = [
            'gestiones' => $gestiones
        ];
        return view('Cvs/GestionAcademica/index', $data);
    }
}

public function save()
{
    $id = session()->get('id');
    if (empty($id)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
    }

    $validation = \Config\Services::validation();
    $validation->setRules(
        [
        'institucion' => 'required|string|max_length[100]',
        'puesto' => 'required|string|max_length[100]',
        'mes_inicio' => 'required',
        'anio_inicio' => 'required',
        'mes_fin' => 'permit_empty',
        'anio_fin' => 'permit_empty',
        'actualmente' => 'permit_empty|in_list[0,1]'
    ],
    [
        'institucion' => [
            'required' => 'El campo institucion es obligatorio',
            'string' => 'El campo institucion debe ser una cadena de texto',
            'max_length' => 'El campo institucion no debe exceder 100 caracteres'
        ],
        'puesto' => [
            'required' => 'El campo puesto es obligatorio',
            'string' => 'El campo puesto debe ser una cadena de texto',
            'max_length' => 'El campo puesto no debe exceder 100 caracteres'
        ],
        'mes_inicio' => [
            'required' => 'El campo mes_inicio es obligatorio'
        ],
        'anio_inicio' => [
            'required' => 'El campo anio_inicio es obligatorio'
        ]
    ]
    );

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setJSON(['success' => false, 'validation' => $validation->getErrors()]);
    }

    $idGestionAcademica = $this->request->getPost('id_gestion_academica');

    $data = [
        'id_usuario' => $id,
        'puesto' => $this->request->getPost('puesto'),
        'institucion' => $this->request->getPost('institucion'),
        'mes_inicio' => $this->request->getPost('mes_inicio'),
        'anio_inicio' => $this->request->getPost('anio_inicio'),
        'actualmente' => $this->request->getPost('actualmente') == '1' ? 1 : 0
    ];

    if ($data['actualmente'] == 0) {
        $data['mes_fin'] = $this->request->getPost('mes_fin');
        $data['anio_fin'] = $this->request->getPost('anio_fin');
    } else {
        $data['mes_fin'] = null;
        $data['anio_fin'] = null;
    }

    try{
        if($idGestionAcademica)
        {
            $this->GestionAcademicaModel->update($idGestionAcademica, $data);
            $message = 'Gestión Academica actualizada correctamente';
        }else{
            $this->GestionAcademicaModel->save($data);
            $message = 'Gestión Academica guardada correctamente';
        }

        return $this->response->setJSON(['success' => true, 'message' => $message]);
    }catch(\Exception $e){
        return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error durante la operación: ' . $e->getMessage()]);
    }
}

public function delete()
{
    $id = session()->get('id');
    if (empty($id)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
    }

    $idGestionAcademica = $this->request->getPost('id_gestion_academica');

    try {
        $this->GestionAcademicaModel->delete($idGestionAcademica);
        return $this->response->setJSON(['success' => true, 'message' => 'Datos eliminados correctamente']);
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error durante la eliminación: ' . $e->getMessage()]);
    }

}


}

