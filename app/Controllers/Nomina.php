<?php

namespace App\Controllers;

use App\Models\NominaModel;
use App\Models\EmpleadoModel;
use CodeIgniter\Controller;

class Nomina extends BaseController
{
    protected $nominaModel;
    protected $empleadoModel;

    public function __construct()
    {
        $this->nominaModel = new NominaModel();
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index()
    {
        $data['titulo'] = 'Gestión de Nómina';
        $data['nominas'] = $this->nominaModel->findAll();

        echo view('layouts/header', $data);
        echo view('nomina/index', $data);
        echo view('layouts/footer');
    }

    public function create()
    {
        $data['titulo'] = 'Registrar Nómina';
        $data['empleados'] = $this->empleadoModel->findAll();

        echo view('layouts/header', $data);
        echo view('nomina/create', $data);
        echo view('layouts/footer');
    }

    public function store()
    {
        $sueldo_base = $this->request->getPost('sueldo_base');
        $bonificacion = $this->request->getPost('bonificacion');
        $igss = $this->request->getPost('IGSS');
        $otros_desc = $this->request->getPost('otros_desc');
        $liquido = $this->request->getPost('liquido');

        $this->nominaModel->save([
            'id_visitador' => $this->request->getPost('id_visitador'),
            'cod_empleado' => $this->request->getPost('cod_empleado'),
            'nombre_empleado' => $this->request->getPost('nombre_empleado'),
            'departamento' => $this->request->getPost('departamento'),
            'sueldo_base' => $sueldo_base,
            'bonificacion' => $bonificacion,
            'IGSS' => $igss,
            'otros_desc' => $otros_desc,
            'liquido' => $liquido
        ]);

        return redirect()->to(base_url('nomina'))->with('msg', 'Registro guardado correctamente.');
    }
    public function edit($id)
{
    $nominaModel = new NominaModel();
    $data['nomina'] = $nominaModel->find($id);

    echo view('layouts/header');
    echo view('nomina/edit', $data);
    echo view('layouts/footer');
}

public function update($id)
{
    $nominaModel = new NominaModel();

    $data = [
        'sueldo_base' => $this->request->getPost('sueldo_base'),
        'bonificacion' => $this->request->getPost('bonificacion'),
        'IGSS' => $this->request->getPost('IGSS'),
        'otros_desc' => $this->request->getPost('otros_desc'),
        'liquido' => $this->request->getPost('liquido'),
    ];

    $nominaModel->update($id, $data);
    return redirect()->to(base_url('nomina'))->with('msg', 'Registro actualizado con éxito.');
}

public function delete($id)
{
    $nominaModel = new NominaModel();
    $nominaModel->delete($id);
    return redirect()->to(base_url('nomina'))->with('msg', 'Registro eliminado con éxito.');
}
}