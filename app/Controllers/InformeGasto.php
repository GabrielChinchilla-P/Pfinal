<?php 
// APPPATH/Controllers/InformeGasto.php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InformeGastoModel;
use App\Models\EmpleadoModel;
use App\Models\DepartamentoModel;

class InformeGasto extends BaseController
{
    protected $informeModel;
    protected $empleadoModel;
    protected $departamentoModel;

    public function __construct()   
    {
        $this->informeModel = new InformeGastoModel();
        $this->empleadoModel = new EmpleadoModel();
        $this->departamentoModel = new DepartamentoModel();
    }

    /** Listar todos los informes */
    public function index()
    {
        $data = [
            'informes' => $this->informeModel->getInformeConEmpleadoYDepartamento(),
            'title'    => 'Gestión de Informes de Gastos'
        ];

        echo view('layouts/header', $data);
        echo view('infgastos/index', $data);
        echo view('layouts/footer');
    }

    /** 🔍 Buscar informes de gastos */
    public function buscar()
    {
        $searchQuery = $this->request->getGet('q');
        $fechaInicio = $this->request->getGet('fecha_inicio');
        $fechaFin    = $this->request->getGet('fecha_fin');

        // Buscar según texto (nombre, apellido, depto, fecha)
        if (!empty($searchQuery)) {
            $informes = $this->informeModel->buscarInformes($searchQuery);
        } else {
            $informes = $this->informeModel->getInformeConEmpleadoYDepartamento();
        }

        // Filtrar por fecha si se proporcionan
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $informes = array_filter($informes, function($item) use ($fechaInicio, $fechaFin) {
                return ($item['fecha_visita'] >= $fechaInicio && $item['fecha_visita'] <= $fechaFin);
            });
        }

        $data = [
            'informes' => $informes,
            'title'    => 'Resultados de Búsqueda'
        ];

        echo view('layouts/header', $data);
        echo view('infgastos/index', $data);
        echo view('layouts/footer');
    }

    /** Mostrar formulario para crear informe */
    public function create()
    {
        $data = [
            'empleados'     => $this->empleadoModel->findAll(),
            'departamentos' => $this->departamentoModel->findAll(),
            'title'         => 'Crear Nuevo Informe de Gasto'
        ];

        echo view('layouts/header', $data);
        echo view('infgastos/create', $data);
        echo view('layouts/footer');
    }

    /** Guardar un nuevo informe */
    public function store()
    {
        $cod_depto = $this->request->getPost('cod_depto');
        $otros = (float) $this->request->getPost('otros');

        // Obtener costos fijos del departamento
        $dept_costos = $this->departamentoModel->obtenerCostosFijos($cod_depto);
        if (!$dept_costos) {
            return redirect()->back()->withInput()->with('error', 'No se encontraron costos fijos para ese departamento.');
        }

        $total = (float)$dept_costos['alojamiento'] 
               + (float)$dept_costos['combustible'] 
               + (float)$dept_costos['alimentacion'] 
               + $otros;

        $data = [
            'id_informe'   => 'INF' . uniqid(),
            'cod_empleado' => $this->request->getPost('cod_empleado'),
            'nombre'       => $this->request->getPost('nombre') ?? '',
            'apellido'     => $this->request->getPost('apellido') ?? '',
            'departamento' => $this->request->getPost('departamento') ?? '',
            'fecha_inicio' => $this->request->getPost('fecha_inicio'),
            'fecha_fin'    => $this->request->getPost('fecha_fin'),
            'fecha_visita' => $this->request->getPost('fecha_visita'),
            'cod_depto'    => $cod_depto,
            'descripcion'  => $this->request->getPost('descripcion'),
            'otros'        => $otros,
            'total'        => $total,
            'alimentacion' => $dept_costos['alimentacion'],
            'alojamiento'  => $dept_costos['alojamiento'],
            'combustible'  => $dept_costos['combustible']
        ];

        $result = $this->informeModel->crearInforme($data);

        if ($result) {
            return redirect()->to(base_url('informegasto'))->with('msg', 'Informe guardado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->informeModel->errors() ?: ['Error desconocido al guardar el informe.']);
    }

    /** Mostrar formulario para editar informe */
    public function edit($id)
    {
        $informe = $this->informeModel->getInformePorID($id);
        if (!$informe) {
            return redirect()->to(base_url('informegasto'))->with('error', 'Informe no encontrado.');
        }

        $data = [
            'informe'       => $informe,
            'empleados'     => $this->empleadoModel->findAll(),
            'departamentos' => $this->departamentoModel->findAll(),
            'title'         => 'Editar Informe de Gastos'
        ];

        echo view('layouts/header', $data);
        echo view('infgastos/edit', $data);
        echo view('layouts/footer');
    }

    /** Actualizar informe existente */
    public function update($id)
    {
        $informe = $this->informeModel->getInformePorID($id);
        if (!$informe) {
            return redirect()->to(base_url('informegasto'))->with('error', 'Informe no encontrado.');
        }

        $cod_depto = $this->request->getPost('cod_depto');
        $otros = (float) $this->request->getPost('otros');

        $dept_costos = $this->departamentoModel->obtenerCostosFijos($cod_depto);
        if (!$dept_costos) {
            return redirect()->back()->withInput()->with('error', 'No se encontraron costos fijos para ese departamento.');
        }

        $total = (float)$dept_costos['alojamiento'] 
               + (float)$dept_costos['combustible'] 
               + (float)$dept_costos['alimentacion'] 
               + $otros;

        $data = [
            'cod_empleado' => $this->request->getPost('cod_empleado'),
            'nombre'       => $this->request->getPost('nombre') ?? '',
            'apellido'     => $this->request->getPost('apellido') ?? '',
            'departamento' => $this->request->getPost('departamento') ?? '',
            'fecha_inicio' => $this->request->getPost('fecha_inicio'),
            'fecha_fin'    => $this->request->getPost('fecha_fin'),
            'fecha_visita' => $this->request->getPost('fecha_visita'),
            'cod_depto'    => $cod_depto,
            'descripcion'  => $this->request->getPost('descripcion'),
            'otros'        => $otros,
            'total'        => $total,
            'alimentacion' => $dept_costos['alimentacion'],
            'alojamiento'  => $dept_costos['alojamiento'],
            'combustible'  => $dept_costos['combustible']
        ];

        $result = $this->informeModel->actualizarInforme($id, $data);

        if ($result) {
            return redirect()->to(base_url('informegasto'))->with('msg', 'Informe actualizado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->informeModel->errors() ?: ['Error desconocido al actualizar el informe.']);
    }

    /** Eliminar un informe */
    public function delete($id)
    {
        $informe = $this->informeModel->getInformePorID($id);
        if (!$informe) {
            return redirect()->to(base_url('informegasto'))->with('error', 'Informe no encontrado.');
        }

        $this->informeModel->eliminarInforme($id);
        return redirect()->to(base_url('informegasto'))->with('msg', 'Informe eliminado correctamente.');
    }
}