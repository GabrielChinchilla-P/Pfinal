<?php

namespace App\Controllers;

use App\Models\BonificacionModel;
use App\Models\EmpleadoModel;

class Bonificacion extends BaseController
{
    protected $bonificacionModel;
    protected $empleadoModel;

    public function __construct()
    {
        $this->bonificacionModel = new BonificacionModel();
        $this->empleadoModel = new EmpleadoModel();
    }

    public function index()
    {
        $data['titulo'] = 'Registro de Bonificaciones';
        $data['bonificaciones'] = $this->bonificacionModel->findAll();

        echo view('layouts/header', $data);
        echo view('bonificacion/index', $data);
        echo view('layouts/footer');
    }

    public function create()
    {
        $data['titulo'] = 'Nueva Bonificación';
        $data['empleados'] = $this->empleadoModel->findAll();

        echo view('layouts/header', $data);
        echo view('bonificacion/create', $data);
        echo view('layouts/footer');
    }

    public function store()
    {
        $ventas = floatval($this->request->getPost('ventas_totales'));

        if ($ventas > 40000) {
            $bonificacion = $ventas * 0.15;
        } elseif ($ventas > 25000) {
            $bonificacion = $ventas * 0.10;
        } else {
            $bonificacion = $ventas * 0.05;
        }

        $this->bonificacionModel->save([
            'id_visitador' => $this->request->getPost('cod_empleado'),
            'nombre_visitador' => $this->request->getPost('nombre_empleado'),
            'ventas_totales' => $ventas,
            'bonificacion' => $bonificacion
        ]);

        return redirect()->to(base_url('bonificacion'))->with('msg', 'Bonificación registrada correctamente.');
    }

    public function edit($id)
    {
        $data['titulo'] = 'Editar Bonificación';
        $data['bonificacion'] = $this->bonificacionModel->find($id);
        $data['empleados'] = $this->empleadoModel->findAll();

        echo view('layouts/header', $data);
        echo view('bonificacion/edit', $data);
        echo view('layouts/footer');
    }

    public function update($id)
    {
        $ventas = floatval($this->request->getPost('ventas_totales'));

        if ($ventas > 40000) {
            $bonificacion = $ventas * 0.15;
        } elseif ($ventas > 25000) {
            $bonificacion = $ventas * 0.10;
        } else {
            $bonificacion = $ventas * 0.05;
        }

        $this->bonificacionModel->update($id, [
            'id_visitador' => $this->request->getPost('cod_empleado'),
            'nombre_visitador' => $this->request->getPost('nombre_empleado'),
            'ventas_totales' => $ventas,
            'bonificacion' => $bonificacion
        ]);

        return redirect()->to(base_url('bonificacion'))->with('msg', 'Bonificación actualizada correctamente.');
    }

    public function delete($id)
    {
        $this->bonificacionModel->delete($id);
        return redirect()->to(base_url('bonificacion'))->with('msg', 'Bonificación eliminada correctamente.');
    }
}