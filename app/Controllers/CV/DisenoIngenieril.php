<?php

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\DisenoIngenieril\DisenoIngenierilModel;
use App\Models\UsuarioModel;

class DisenoIngenieril extends BaseController
{


    protected $disenoIngenierilModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->disenoIngenierilModel = new DisenoIngenierilModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $id = session()->get('id');

        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }


        if (isset($_SESSION['id'])) {
            $id_usuario = $_SESSION['id'];
            $disenoIngenieril = $this->disenoIngenierilModel->where('id_usuario', $id_usuario)->findAll();
            $data = [
                'disenoIngenieril' => $disenoIngenieril
            ];

        }

        return view('Cvs/DisenoIngenieril/index', $data);
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
                'organismo' => 'required|string|max_length[100]',
                'anio_inicio' => 'required',
                'anio_fin' => 'required',
                'nivel_experiencia' => 'required|in_list[responsable,asistente,analista,auxiliar,otro]',  
                'otro_nivel' => 'permit_empty'
            ],
            [
                'organismo' => [
                    'required' => 'El organismo es requerido',
                    'string' => 'El organismo debe ser una cadena de texto',
                    'max_length' => 'El organismo no puede exceder los 100 caracteres'
                ],
                'anio_inicio' => [
                    'required' => 'El año de inicio es requerido'
                ],
                'anio_fin' => [
                    'required' => 'El año de fin es requerido'
                ],
                'nivel_experiencia' => [
                    'required' => 'El nivel de experiencia es requerido',
                    'in_list' => 'El nivel de experiencia no es válido'  
                ]
            ]
        );
        
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
    
        $idDisenoIngineril = $this->request->getPost('id_diseno_ingenieril');
    
        $disenoIngenierilData = [
            'id_usuario' => $id,
            'organismo' => esc($this->request->getPost('organismo')),
            'anio_inicio' => esc($this->request->getPost('anio_inicio')),
            'anio_fin' => esc($this->request->getPost('anio_fin')),
            'nivel_experiencia' => esc($this->request->getPost('nivel_experiencia')),
            'otro_nivel' => esc($this->request->getPost('otro_nivel'))
        ];
    
        if ($disenoIngenierilData['nivel_experiencia'] !== 'otro') {
            $disenoIngenierilData['otro_nivel'] = '';
        }
    
        try {
            if ($idDisenoIngineril) {
                $this->disenoIngenierilModel->update($idDisenoIngineril, $disenoIngenierilData);
                $message = 'Datos actualizados correctamente';
            } else {
                $this->disenoIngenierilModel->save($disenoIngenierilData);
                $message = 'Datos guardados correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        $id = session()->get('id');
        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }
    
        $idDisenoIngenieril = $this->request->getPost('id');
    
        if ($this->disenoIngenierilModel->delete($idDisenoIngenieril)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Datos eliminados correctamente']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error al eliminar los datos']);
        }
    }

}