<?php

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\AportacionPE\AportacionPEModel;
use App\Models\UsuarioModel;

class AportacionPE extends BaseController
{
    protected $aportacionPEModel;
    protected $usuarioModel;


    public function __construct()
    {
        $this->aportacionPEModel = new AportacionPEModel();
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
            $aportaciones = $this->aportacionPEModel->where('id_usuario', $id_usuario)->findAll();
            $data = [
                'aportaciones' => $aportaciones
            ];
            return view('Cvs/AportacionPE/index', $data);
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
                'descripcion' => 'required|string|max_length[1000]'
            ],
            [
                'descripcion' => [
                    'required' => 'El campo descripción es obligatorio',
                    'string' => 'El campo descripción debe ser un texto',
                    'max_length' => 'El campo descripción no puede superar las 200 palabras'
                ]
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $idAportacion = $this->request->getPost('id_aportacion');

        $data = [
            'id_usuario' => $id,
            'descripcion' => $this->request->getPost('descripcion')
        ];

        try {
            if (empty($idAportacion)) {
                $this->aportacionPEModel->save($data);
                $message = 'Aportación guardada correctamente';
            } else {
                $this->aportacionPEModel->update($idAportacion, $data);
                $message = 'Aportación actualizada correctamente';
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar la aportación']);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Aportación guardada correctamente']);
    }


    public function delete($id)
    {
        try {
            $this->aportacionPEModel->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Aportación eliminada correctamente']);

        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar la aportación']);
        }
    }



}