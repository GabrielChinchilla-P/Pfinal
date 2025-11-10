<?php

namespace App\Controllers;

use App\Models\NominaModel;
use App\Models\EmpleadoModel;
use CodeIgniter\Controller;

class Nomina extends BaseController
{
    protected $nominaModel;
    protected $empleadoModel;
    protected $session;

    public function __construct()
    {
        $this->nominaModel = new NominaModel();
        $this->empleadoModel = new EmpleadoModel();
        $this->session = session();
    }

    /**
     * 📋 Lista de registros de nómina con verificación de acceso
     */
    public function index()
    {
        // 🔒 Verificar sesión y rol
        if (!$this->session->has('usuario') || $this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado. Solo el administrador puede acceder a la nómina.');
            return redirect()->to(base_url('menu'));
        }

        $data = [
            'titulo' => 'Gestión de Nómina',
            'usuario' => $this->session->get('usuario'),
            'rol' => $this->session->get('rol'),
            'nominas' => $this->nominaModel->findAll()
        ];

        echo view('layouts/header', $data);
        echo view('nomina/index', $data);
        echo view('layouts/footer');
    }

    /**
     * 🧾 Formulario para crear nueva nómina
     */
    public function create()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado. Solo el administrador puede registrar nómina.');
            return redirect()->to(base_url('menu'));
        }

        $data = [
            'titulo' => 'Registrar Nómina',
            'empleados' => $this->empleadoModel->findAll(),
        ];

        echo view('layouts/header', $data);
        echo view('nomina/create', $data);
        echo view('layouts/footer');
    }

    /**
     * 💾 Guardar registro de nómina
     */
    public function store()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $data = [
            'id_visitador'   => $this->request->getPost('id_visitador'),
            'cod_empleado'   => $this->request->getPost('cod_empleado'),
            'nombre_empleado'=> $this->request->getPost('nombre_empleado'),
            'departamento'   => $this->request->getPost('departamento'),
            'sueldo_base'    => $this->request->getPost('sueldo_base'),
            'bonificacion'   => $this->request->getPost('bonificacion'),
            'IGSS'           => $this->request->getPost('IGSS'),
            'otros_desc'     => $this->request->getPost('otros_desc'),
            'liquido'        => $this->request->getPost('liquido')
        ];

        $this->nominaModel->save($data);
        return redirect()->to(base_url('nomina'))->with('msg', 'Registro guardado correctamente.');
    }

    /**
     * ✏️ Editar nómina existente
     */
    public function edit($id)
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $data['nomina'] = $this->nominaModel->find($id);

        echo view('layouts/header');
        echo view('nomina/edit', $data);
        echo view('layouts/footer');
    }

    /**
     * 🔁 Actualizar registro
     */
    public function update($id)
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $data = [
            'sueldo_base'  => $this->request->getPost('sueldo_base'),
            'bonificacion' => $this->request->getPost('bonificacion'),
            'IGSS'         => $this->request->getPost('IGSS'),
            'otros_desc'   => $this->request->getPost('otros_desc'),
            'liquido'      => $this->request->getPost('liquido'),
        ];

        $this->nominaModel->update($id, $data);
        return redirect()->to(base_url('nomina'))->with('msg', 'Registro actualizado con éxito.');
    }

    /**
     * ❌ Eliminar registro
     */
    public function delete($id)
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $this->nominaModel->delete($id);
        return redirect()->to(base_url('nomina'))->with('msg', 'Registro eliminado con éxito.');
    }
}