<?php 

namespace App\Controllers\CV;

use App\Controllers\BaseController;
use App\Models\CV\ProductoAcademico\ProductoAcademicoModel;
use App\Models\UsuarioModel;

class ProductoAcademico extends BaseController
{

    private $productoAcademicoModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->productoAcademicoModel = new ProductoAcademicoModel();
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
            $productos = $this->productoAcademicoModel->where('id_usuario', $id_usuario)
                                                     ->orderBy('orden', 'ASC')
                                                     ->findAll();
            $data = [
                'productos' => $productos
            ];

            return view('Cvs/ProductoAcademico/index', $data);
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
                    'max_length' => 'El campo descripción no puede superar los 1000 caracteres'
                ]
            ]
        );
    
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }
    
        $idProductoAcademico = $this->request->getPost('id_producto_academico');
        $maxOrden = $this->productoAcademicoModel->where('id_usuario', $id)->selectMax('orden')->first();
        $siguienteOrden = 1;
        
        if ($maxOrden) {
            if (is_object($maxOrden) && isset($maxOrden->orden)) {
                $siguienteOrden = $maxOrden->orden + 1;
            } elseif (is_array($maxOrden) && isset($maxOrden['orden'])) {
                $siguienteOrden = $maxOrden['orden'] + 1;
            }
        }
    
        $data = [
            'id_usuario' => $id,
            'descripcion' => $this->request->getPost('descripcion')
        ];
    
        if (!$idProductoAcademico) {
            $data['orden'] = $siguienteOrden;
        }
    
        try {
            if ($idProductoAcademico) {
                $this->productoAcademicoModel->update($idProductoAcademico, $data);
                $message = 'Datos actualizados correctamente';
            } else {
                $this->productoAcademicoModel->insert($data);  
                $message = 'Datos guardados correctamente';
            }
            return $this->response->setJSON(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {

            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Ocurrió un error durante la operación: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function updateOrder()
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }
    
        $ordenamiento = $this->request->getJSON(true);
        
        try {
            foreach ($ordenamiento as $item) {
                $producto = $this->productoAcademicoModel->where('id', $item['id'])
                                                       ->where('id_usuario', $id_usuario)
                                                       ->first();
                
                if (!$producto) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Uno o más productos no encontrados o no tienes permiso']);
                }
            }

            foreach ($ordenamiento as $index => $item) {
                $this->productoAcademicoModel->update($item['id'], ['orden' => $index + 1]);
            }
            
            return $this->response->setJSON(['success' => true, 'message' => 'Orden actualizado correctamente']);
        } catch(\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar el orden: ' . $e->getMessage()]);
        }
    }
    public function delete($id = null)
    {
        $id_usuario = session()->get('id');
        if (empty($id_usuario)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Sesión no válida']);
        }
    
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID no proporcionado']);
        }
    
        try {
            $producto = $this->productoAcademicoModel->where('id', $id)
                                                    ->where('id_usuario', $id_usuario)
                                                    ->first();
                                                    
            if (!$producto) {
                return $this->response->setJSON(['success' => false, 'message' => 'Producto no encontrado o no tienes permiso']);
            }
    
            $this->productoAcademicoModel->delete($id);
            
            $this->reordenarProductos($id_usuario);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Producto eliminado correctamente']);
        } catch(\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ocurrió un error durante la operación: ' . $e->getMessage()]);
        }
    }
    
    private function reordenarProductos($id_usuario) {
        $productos = $this->productoAcademicoModel->where('id_usuario', $id_usuario)
                                                ->orderBy('orden', 'ASC')
                                                ->findAll();
        
        foreach ($productos as $index => $producto) {
            $this->productoAcademicoModel->update($producto['id'], ['orden' => $index + 1]);
        }
    }
}
