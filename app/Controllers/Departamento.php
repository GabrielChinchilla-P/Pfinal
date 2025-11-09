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
}