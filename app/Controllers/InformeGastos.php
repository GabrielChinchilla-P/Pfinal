<?php namespace App\Controllers;

use App\Models\InformeModel;
use App\Models\EmpleadosModel;
use CodeIgniter\Controller;

class InformeGastos extends Controller
{
    protected $informeModel;
    protected $empleadoModel;
    protected $session;

    public function __construct()
    {
        $this->informeModel = new InformeModel();
        $this->empleadoModel = new EmpleadosModel();
        $this->session = session();
    }

    // 🏠 Página principal
    public function index()
    {
        $data['informes'] = $this->informeModel
            ->select('
                informe_gastos.*,
                empleados.nombre AS emp_nombre,
                empleados.apellido AS emp_apellido,
                departamentos.id_departamento AS emp_departamento
            ')
            ->join('empleados', 'empleados.id_empleado = informe_gastos.id_empleado', 'left')
            ->join('departamentos', 'departamentos.id_departamento = informe_gastos.id_departamento', 'left')
            ->findAll();

        $data['empleados'] = $this->empleadoModel->findAll();

        return view('templates/header')
            . view('informe_gastos/index', $data)
            . view('templates/footer');
    }
}