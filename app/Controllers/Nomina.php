<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NominaModel;
use App\Models\UserModel;

class Nomina extends Controller
{
    protected $nominaModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->nominaModel = new NominaModel();
        $this->userModel   = new UserModel();
        $this->session     = session();
    }

    /**
     * 📋 Muestra la lista de registros de nómina con búsqueda
     */
    public function index()
    {
        // 1. Verificación de acceso
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado. No tienes permisos para ver la Nómina.');
            return redirect()->to(base_url('menu'));
        }

        // 2. Obtener parámetro de búsqueda (si existe)
        $searchQuery = $this->request->getGet('q');

        // 3. Construir la consulta principal
        $builder = $this->nominaModel
            ->select('
                nomina.id_nomina,
                nomina.mes,
                nomina.sueldo_base,
                nomina.bonificacion,
                nomina.IGSS,
                nomina.descuentos,
                nomina.sueldo_liquido,
                empleados.nombre AS nombre_empleado,
                empleados.apellido AS apellido_empleado,
                usuarios.usuario AS nombre_usuario
            ')
            ->join('empleados', 'empleados.id_empleado = nomina.id_empleado', 'left')
            ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario', 'left');

        // 4. Aplicar filtro de búsqueda si se ingresó texto
        if (!empty($searchQuery)) {
            $builder->groupStart()
                ->like('nomina.mes', $searchQuery)
                ->orLike('empleados.nombre', $searchQuery)
                ->orLike('empleados.apellido', $searchQuery)
                ->orLike('usuarios.usuario', $searchQuery)
                ->groupEnd();
        }

        // 5. Obtener resultados ordenados
        $nominas = $builder->orderBy('nomina.mes', 'DESC')
                           ->get()
                           ->getResult();

        // 6. Enviar datos a la vista
        $data = [
            'title'       => 'Gestión de Nómina',
            'usuario'     => $this->session->get('usuario'),
            'rol'         => $this->session->get('rol'),
            'nominas'     => $nominas,
            'searchQuery' => $searchQuery,
        ];

        return view('nomina/index', $data);
    }

    /**
     * 🧾 Muestra el formulario para crear una nueva nómina
     */
    public function create()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        $empleados = $this->userModel->select('id_usuario, nombre, usuario')->findAll();

        $data = [
            'title'      => 'Calcular Nueva Nómina',
            'empleados'  => $empleados,
            'validation' => \Config\Services::validation(),
        ];

        return view('nomina/create', $data);
    }

    /**
     * 💾 Guarda un nuevo registro de nómina
     */
    public function store()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        // Calcular valores
        $id_empleado  = $this->request->getPost('id_empleado');
        $mes          = $this->request->getPost('mes');
        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $descuentos   = (float) $this->request->getPost('descuentos') ?? 0;

        $tasa_igss      = 0.0483;
        $igss_calculado = round($sueldo_base * $tasa_igss, 2);
        $sueldo_liquido = $sueldo_base + $bonificacion - $igss_calculado - $descuentos;

        $data = [
            'id_empleado'    => $id_empleado,
            'mes'            => $mes,
            'sueldo_base'    => $sueldo_base,
            'bonificacion'   => $bonificacion,
            'IGSS'           => $igss_calculado,
            'descuentos'     => $descuentos,
            'sueldo_liquido' => $sueldo_liquido,
        ];

        $this->nominaModel->save($data);

        $this->session->setFlashdata('success', 'Nómina calculada y registrada correctamente.');
        return redirect()->to(base_url('nomina'));
    }

    /**
     * ✏️ Muestra el formulario para editar una nómina existente
     */
    public function edit($id_nomina = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_nomina === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('nomina'));
        }

        $nomina = $this->nominaModel->find($id_nomina);
        if (!$nomina) {
            $this->session->setFlashdata('msg', 'Registro de nómina no encontrado.');
            return redirect()->to(base_url('nomina'));
        }

        $empleados = $this->userModel->select('id_usuario, nombre, usuario')->findAll();

        $data = [
            'title'      => 'Editar Registro de Nómina',
            'nomina'     => $nomina,
            'empleados'  => $empleados,
            'validation' => \Config\Services::validation(),
        ];

        return view('nomina/edit', $data);
    }

    /**
     * 🔁 Actualiza un registro de nómina existente
     */
    public function update($id_nomina = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_nomina === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('nomina'));
        }

        $id_empleado  = $this->request->getPost('id_empleado');
        $mes          = $this->request->getPost('mes');
        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $descuentos   = (float) $this->request->getPost('descuentos') ?? 0;

        $tasa_igss      = 0.0483;
        $igss_calculado = round($sueldo_base * $tasa_igss, 2);
        $sueldo_liquido = $sueldo_base + $bonificacion - $igss_calculado - $descuentos;

        $data = [
            'id_nomina'      => $id_nomina,
            'id_empleado'    => $id_empleado,
            'mes'            => $mes,
            'sueldo_base'    => $sueldo_base,
            'bonificacion'   => $bonificacion,
            'IGSS'           => $igss_calculado,
            'descuentos'     => $descuentos,
            'sueldo_liquido' => $sueldo_liquido,
        ];

        $this->nominaModel->save($data);

        $this->session->setFlashdata('success', 'Registro de nómina actualizado correctamente.');
        return redirect()->to(base_url('nomina'));
    }

    /**
     * ❌ Elimina un registro de nómina
     */
    public function delete($id_nomina = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_nomina === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('nomina'));
        }

        if ($this->nominaModel->delete($id_nomina)) {
            $this->session->setFlashdata('success', 'Registro de nómina eliminado con éxito.');
        } else {
            $this->session->setFlashdata('msg', 'Error al intentar eliminar el registro.');
        }

        return redirect()->to(base_url('nomina'));
    }
    
}