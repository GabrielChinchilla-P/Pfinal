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
        $this->nominaModel   = new NominaModel();
        $this->empleadoModel = new EmpleadoModel();
        $this->session       = session();
    }

    /**
     * 📋 Lista de nómina con verificación de acceso
     */
    public function index()
    {
        // Verificar rol de administrador
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado. No tienes permisos para ver la Nómina.');
            return redirect()->to(base_url('menu'));
        }

        // Obtener registros
        $nominas = $this->nominaModel->findAll();

        // Convertir objetos a arrays para la vista
        $nominas = array_map(function($n){ return (array) $n; }, $nominas);

        $data['titulo']  = 'Gestión de Nómina';
        $data['nominas'] = $nominas;

        echo view('layouts/header', $data);
        echo view('nomina/index', $data);
        echo view('layouts/footer');
    }

    /**
     * 🧾 Formulario para crear nueva nómina
     */
    public function create()
    {
        // Verificar rol
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $data['titulo']    = 'Registrar Nómina';
        $data['empleados'] = $this->empleadoModel->findAll();

        echo view('layouts/header', $data);
        echo view('nomina/create', $data);
        echo view('layouts/footer');
    }

    /**
     * 💾 Guardar nueva nómina
     */
    public function store()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $IGSS         = (float) $this->request->getPost('IGSS') ?? 0;
        $otros_desc   = (float) $this->request->getPost('otros_desc') ?? 0;
        $liquido      = $sueldo_base + $bonificacion - $IGSS - $otros_desc;

        $this->nominaModel->save([
            'id_visitador'     => $this->request->getPost('id_visitador'),
            'cod_empleado'     => $this->request->getPost('cod_empleado'),
            'nombre_empleado'  => $this->request->getPost('nombre_empleado'),
            'departamento'     => $this->request->getPost('departamento'),
            'sueldo_base'      => $sueldo_base,
            'bonificacion'     => $bonificacion,
            'IGSS'             => $IGSS,
            'otros_desc'       => $otros_desc,
            'liquido'          => $liquido
        ]);

        return redirect()->to(base_url('nomina'))->with('msg', 'Registro guardado correctamente.');
    }

    /**
     * ✏️ Formulario para editar nómina
     */
    public function edit($id)
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $nomina = $this->nominaModel->find($id);
        if (!$nomina) {
            return redirect()->to(base_url('nomina'))->with('msg', 'Registro no encontrado.');
        }

        $data['nomina']    = (array) $nomina; // Convertir objeto a array
        $data['empleados'] = $this->empleadoModel->findAll();
        $data['titulo']    = 'Editar Nómina';

        echo view('layouts/header', $data);
        echo view('nomina/edit', $data);
        echo view('layouts/footer');
    }

    /**
     * 🔁 Actualizar nómina
     */
    public function update($id)
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $IGSS         = (float) $this->request->getPost('IGSS') ?? 0;
        $otros_desc   = (float) $this->request->getPost('otros_desc') ?? 0;
        $liquido      = $sueldo_base + $bonificacion - $IGSS - $otros_desc;

        $this->nominaModel->update($id, [
            'sueldo_base'     => $sueldo_base,
            'bonificacion'    => $bonificacion,
            'IGSS'            => $IGSS,
            'otros_desc'      => $otros_desc,
            'liquido'         => $liquido
        ]);

        return redirect()->to(base_url('nomina'))->with('msg', 'Registro actualizado correctamente.');
    }

    /**
     * ❌ Eliminar nómina
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