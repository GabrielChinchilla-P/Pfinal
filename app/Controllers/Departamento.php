<?php namespace App\Controllers;

use App\Models\DepartamentoModel;

class Departamento extends BaseController
{
    protected $departamentoModel;

    public function __construct()
    {
        $this->departamentoModel = new DepartamentoModel();
    }

    public function index()
    {
        $data['titulo'] = 'Departamentos';
        $data['departamentos'] = $this->departamentoModel->findAll();

        echo view('layouts/header', $data);
        echo view('departamento/index', $data);
        echo view('layouts/footer');
    }

    public function create()
    {
        $data['titulo'] = 'Registrar Departamento';
        echo view('layouts/header', $data);
        echo view('departamento/create', $data);
        echo view('layouts/footer');
    }

    public function store()
    {
        $distancia = floatval($this->request->getPost('distancia'));
        $alojamiento = floatval($this->request->getPost('alojamiento'));
        $alimentacion = floatval($this->request->getPost('alimentacion'));
        $combustible = (($distancia / 35) * 30.54) * 2;

        $this->departamentoModel->save([
            'depto' => $this->request->getPost('depto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'distancia' => $distancia,
            'alojamiento' => $alojamiento,
            'alimentacion' => $alimentacion,
            'combustible' => $combustible
        ]);

        return redirect()->to(base_url('departamento'))->with('msg', 'Departamento registrado correctamente.');
    }

    public function edit($id)
    {
        $data['titulo'] = 'Editar Departamento';
        $data['departamento'] = $this->departamentoModel->find($id);

        echo view('layouts/header', $data);
        echo view('departamento/edit', $data);
        echo view('layouts/footer');
    }

    public function update($id)
    {
        $distancia = floatval($this->request->getPost('distancia'));
        $alojamiento = floatval($this->request->getPost('alojamiento'));
        $alimentacion = floatval($this->request->getPost('alimentacion'));
        $combustible = (($distancia / 35) * 30.54) * 2;

        $this->departamentoModel->update($id, [
            'descripcion' => $this->request->getPost('descripcion'),
            'distancia' => $distancia,
            'alojamiento' => $alojamiento,
            'alimentacion' => $alimentacion,
            'combustible' => $combustible
        ]);

        return redirect()->to(base_url('departamento'))->with('msg', 'Departamento actualizado correctamente.');
    }

    public function delete($id)
    {
        $this->departamentoModel->delete($id);
        return redirect()->to(base_url('departamento'))->with('msg', 'Departamento eliminado correctamente.');
    }

public function ajaxCosto($id)
{
    $departamento = $this->departamentoModel->find($id);

    if ($departamento) {
        return $this->response->setJSON([
            'alimentacion' => floatval($departamento['alimentacion']),
            'alojamiento' => floatval($departamento['alojamiento']),
            'combustible' => floatval($departamento['combustible']),
        ]);
    } else {
        return $this->response->setJSON([
            'alimentacion' => 0,
            'alojamiento' => 0,
            'combustible' => 0,
            'mensaje' => 'No se encontraron costos fijos para este departamento'
        ]);
    }
}
}