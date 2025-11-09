<?php namespace App\Controllers;

use App\Models\BonificacionModel;
use CodeIgniter\Controller;


class Bonificacion extends Controller
{
    protected $bonificacionModel;

    public function __construct()
    {
        $this->bonificacionModel = new BonificacionModel();
    }

 // 📋 Listar registros
    public function index()
    {
        $data['bonificacion'] = $this->bonificacionModel->findAll();
        echo view('templates/header');
        echo view('bonificacion/index', $data);
        echo view('templates/footer');
    }

    // 🔍 Buscar
    public function buscar()
    {
        $busqueda = $this->request->getGet('q');
        if ($busqueda) {
            $data['bonificacion'] = $this->bonificacionModel
                ->like('id_visitador', $busqueda)
                ->orLike('nombre_visitador', $busqueda)
                ->findAll();
        } else {
            $data['bonificacion'] = $this->bonificacionModel->findAll();
        }

        echo view('templates/header');
        echo view('bonificacion/index', $data);
        echo view('templates/footer');
    }