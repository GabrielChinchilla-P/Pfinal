<?php namespace App\Controllers;

use App\Models\DepartamentosModel;
use CodeIgniter\Controller;

class Departamentos extends Controller
{
    protected $departamentosModel;

    public function __construct()
    {
        $this->departamentosModel = new DepartamentosModel();
    }

    // 📄 Mostrar lista
    public function index()
    {
        $data['departamentos'] = $this->departamentosModel->findAll();
        echo view('templates/header');
        echo view('departamentos/index', $data);
        echo view('templates/footer');
    }
     // 🔍 Buscar departamentos
public function buscar()
{
    $query = $this->request->getGet('q'); // obtiene lo que el usuario escribió

    if ($query) {
        // Busca por código o descripción
        $departamentos = $this->departamentosModel
            ->like('depto', $query)
            ->orLike('descripcion', $query)
            ->findAll();
    } else {
        $departamentos = $this->departamentosModel->findAll();
    }

    // Retorna a la misma vista con los resultados
    return view('templates/header')
        . view('departamentos/index', ['departamentos' => $departamentos])
        . view('templates/footer');
}

}