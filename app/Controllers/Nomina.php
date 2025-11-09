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
        $this->userModel = new UserModel();
        $this->session = session();
    }

    /**
     * Muestra la lista de registros de nómina con capacidad de búsqueda. (R del CRUD)
     */
    public function index()
    {
        // 1. AUTORIZACIÓN: Solo permitir acceso a 'admin'
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado. No tienes permisos para ver la Nómina.');
            return redirect()->to(base_url('menu')); 
        }
        
        // 2. LÓGICA DE BÚSQUEDA
        $searchQuery = $this->request->getGet('q');
        
        // 💡 CORRECCIÓN CRÍTICA: Se listan explícitamente todos los campos de 'nomina' 
        // para garantizar que 'IGSS' y 'sueldo_liquido' sean incluidos en el resultado.
        $builder = $this->nominaModel->select('
            nomina.id_nomina, 
            nomina.mes, 
            nomina.sueldo_base, 
            nomina.bonificacion, 
            nomina.IGSS,         /* <-- ¡Campo IGSS asegurado! */
            nomina.descuentos, 
            nomina.sueldo_liquido,
            
            empleados.nombre as nombre_empleado, 
            empleados.apellido as apellido_empleado, /* <-- Añadido para mostrar el nombre completo */
            usuarios.usuario as nombre_usuario
        ')
        ->join('empleados', 'empleados.id_empleado = nomina.id_empleado', 'left') 
        ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario', 'left'); 

        if ($searchQuery) {
            // Aplicar filtros de búsqueda
            $builder->orLike('nomina.mes', $searchQuery)
                    ->orLike('empleados.nombre', $searchQuery) 
                    ->orLike('empleados.apellido', $searchQuery) 
                    ->orLike('usuarios.usuario', $searchQuery);
        }

        $nominas = $builder->orderBy('nomina.mes', 'DESC')
                           ->findAll();


        $data = [
            'title'       => 'Gestión de Nómina',
            'usuario'     => $this->session->get('usuario'),
            'rol'         => $this->session->get('rol'),
            'nominas'     => $nominas, 
            'searchQuery' => $searchQuery, // Pasamos el query de vuelta a la vista
        ];

        return view('nomina/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de nómina. (C del CRUD)
     */
    public function create()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        // Obtener la lista de usuarios (empleados) para el desplegable
        $empleados = $this->userModel->select('id_usuario, nombre, usuario')->findAll();

        $data = [
            'title'      => 'Calcular Nueva Nómina',
            'empleados'  => $empleados,
            'validation' => \Config\Services::validation(),
        ];

        return view('nomina/create', $data);
    }
    
    /**
     * Guarda el nuevo registro de nómina. (C del CRUD)
     * 💡 MÉTODO CORREGIDO CON BLOQUE DE DIAGNÓSTICO
     */
    public function store()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        // 1. Obtener y calcular datos
        $id_empleado  = $this->request->getPost('id_empleado');
        $mes          = $this->request->getPost('mes');
        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $descuentos   = (float) $this->request->getPost('descuentos') ?? 0;

        $tasa_igss = 0.0483; 
        $igss_calculado = round($sueldo_base * $tasa_igss, 2);

        $sueldo_liquido = $sueldo_base + $bonificacion - $igss_calculado - $descuentos;

        // 2. Preparar datos para el Modelo
        $data = [
            'id_empleado'    => $id_empleado,
            'mes'            => $mes,
            'sueldo_base'    => $sueldo_base,
            'bonificacion'   => $bonificacion,
            'IGSS'           => $igss_calculado,
            'descuentos'     => $descuentos,
            'sueldo_liquido' => $sueldo_liquido,
        ];

        // =========================================================
        // 🚨 BLOQUE DE DIAGNÓSTICO (¡TEMPORAL!) 🚨
        // =========================================================
        if (! $this->nominaModel->validate($data)) {
            // Error de validación
            echo "<h1>❌ ERROR DE VALIDACIÓN</h1>";
            echo "<p>La nómina no se pudo guardar debido a la validación. Revisa el listado de errores:</p>";
            dd($this->nominaModel->errors()); 
        }

        // Intentar Guardar en la base de datos
        $guardado = $this->nominaModel->save($data);

        if ($guardado === false) {
            // Error de DB después de la validación
            echo "<h1>❌ ERROR DE BASE DE DATOS AL GUARDAR</h1>";
            echo "<p>La validación pasó, pero la base de datos rechazó el registro. Revisa el error de la DB:</p>";
            dd($this->nominaModel->db->error());
        }
        // =========================================================
        // FIN DEL BLOQUE DE DIAGNÓSTICO
        // =========================================================

        // Si llega aquí, significa que el guardado fue exitoso
        $this->session->setFlashdata('success', 'Nómina calculada y registrada correctamente.');
        return redirect()->to(base_url('nomina'));
    }

    // ... (El resto de tus métodos: edit, update, delete)
    
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
    
    public function update($id_nomina = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_nomina === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('nomina'));
        }

        // 1. Obtener datos y realizar el cálculo
        $id_empleado  = $this->request->getPost('id_empleado');
        $mes          = $this->request->getPost('mes');
        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $descuentos   = (float) $this->request->getPost('descuentos') ?? 0;

        $tasa_igss = 0.0483; 
        $igss_calculado = round($sueldo_base * $tasa_igss, 2);
        $sueldo_liquido = $sueldo_base + $bonificacion - $igss_calculado - $descuentos;

        // 2. Preparar datos para el Modelo
        $data = [
            'id_nomina'      => $id_nomina, // ¡Importante para la actualización!
            'id_empleado'    => $id_empleado,
            'mes'            => $mes,
            'sueldo_base'    => $sueldo_base,
            'bonificacion'   => $bonificacion,
            'IGSS'           => $igss_calculado,
            'descuentos'     => $descuentos,
            'sueldo_liquido' => $sueldo_liquido,
        ];
        
        if (! $this->nominaModel->validate($data)) {
            $this->session->setFlashdata('errors', $this->nominaModel->errors());
            return redirect()->back()->withInput();
        }

        // 4. Actualizar en la base de datos
        $this->nominaModel->save($data);

        $this->session->setFlashdata('success', 'Registro de nómina actualizado correctamente.');
        return redirect()->to(base_url('nomina'));
    }
    
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