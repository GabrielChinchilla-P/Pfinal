<?php namespace App\Controllers;

use App\Models\EmpleadoModel;

class Empleado extends BaseController
{
    protected $empleadoModel;

    public function __construct()
    {
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index()
    {
        $data['titulo'] = 'Empleados';
        $data['empleados'] = $this->empleadoModel->findAll();

        echo view('layouts/header', $data);
        echo view('empleado/index', $data);
        echo view('layouts/footer');
    }

    public function create()
    {
        $data['titulo'] = 'Registrar Empleado';
        echo view('layouts/header', $data);
        echo view('empleado/create', $data);
        echo view('layouts/footer');
    }

    public function store()
    {
        $this->empleadoModel->save([
            'cod_empleado' => $this->request->getPost('cod_empleado'),
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'departamento' => $this->request->getPost('departamento'),
            'fecha_ingreso' => $this->request->getPost('fecha_ingreso')
        ]);

        return redirect()->to(base_url('empleado'))->with('msg', 'Empleado registrado correctamente.');
    }

    public function edit($id)
    {
        $data['titulo'] = 'Editar Empleado';
        $data['empleado'] = $this->empleadoModel->find($id);

        echo view('layouts/header', $data);
        echo view('empleado/edit', $data);
        echo view('layouts/footer');
    }

    public function update($id)
    {
        $this->empleadoModel->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'departamento' => $this->request->getPost('departamento'),
            'fecha_ingreso' => $this->request->getPost('fecha_ingreso')
        ]);

        return redirect()->to(base_url('empleado'))->with('msg', 'Empleado actualizado correctamente.');
    }

    public function delete($id)
    {
        $this->empleadoModel->delete($id);
        return redirect()->to(base_url('empleado'))->with('msg', 'Empleado eliminado correctamente.');
    }
}