<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\NominaModel;
use App\Models\UserModel;
// No es necesario importar \Config\Services::validation() si usamos $this->nominaModel->validate()

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
        $searchQuery = $this->request->getGet('q'); // Obtener el parámetro de búsqueda 'q'
        
        if ($searchQuery) {
            // Si hay término de búsqueda, filtramos. 
            $nominas = $this->nominaModel->select('nomina.*, usuarios.nombre as nombre_empleado, usuarios.usuario as nombre_usuario')
                                         ->join('usuarios', 'usuarios.id_usuario = nomina.id_empleado')
                                         ->orLike('nomina.mes', $searchQuery)
                                         ->orLike('usuarios.nombre', $searchQuery)
                                         ->orLike('usuarios.usuario', $searchQuery)
                                         ->orderBy('nomina.mes', 'DESC')
                                         ->findAll();
        } else {
            // Si no hay búsqueda, usamos la función JOIN estándar
            $nominas = $this->nominaModel->getNominaConEmpleado();
        }

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
     */
    public function store()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        // 1. Obtener datos
        $id_empleado  = $this->request->getPost('id_empleado');
        $mes          = $this->request->getPost('mes');
        $sueldo_base  = (float) $this->request->getPost('sueldo_base');
        $bonificacion = (float) $this->request->getPost('bonificacion') ?? 0;
        $descuentos   = (float) $this->request->getPost('descuentos') ?? 0;

        // CÁLCULO ESPECÍFICO DE IGSS 
        $tasa_igss = 0.0483; 
        $igss_calculado = round($sueldo_base * $tasa_igss, 2);

        // CÁLCULO FINAL
        $sueldo_liquido = $sueldo_base + $bonificacion - $igss_calculado - $descuentos;

        // 2. Preparar datos para el Modelo
        $data = [
            'id_empleado'    => $id_empleado, // <--- Este es el campo clave
            'mes'            => $mes,
            'sueldo_base'    => $sueldo_base,
            'bonificacion'   => $bonificacion,
            'IGSS'           => $igss_calculado,
            'descuentos'     => $descuentos,
            'sueldo_liquido' => $sueldo_liquido,
        ];

        // =========================================================
        // 💡 CORRECCIÓN CLAVE: Usar la validación del modelo
        // que incluye 'is_not_unique[empleados.id_empleado]'
        // =========================================================
        if (! $this->nominaModel->validate($data)) {
            // Si la validación falla (incluyendo el ID de empleado inexistente)
            $this->session->setFlashdata('errors', $this->nominaModel->errors());
            // Si usas el validador del controlador, puedes reemplazar la línea de arriba con:
            // $this->session->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->back()->withInput();
        }

        // 4. Guardar en la base de datos (Línea 133 original)
        $this->nominaModel->save($data);

        $this->session->setFlashdata('success', 'Nómina calculada y registrada correctamente.');
        return redirect()->to(base_url('nomina'));
    }

    /**
     * Muestra el formulario para editar un registro existente. (U del CRUD)
     * @param int $id_nomina
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
     * Procesa la actualización de un registro de nómina. (U del CRUD)
     * @param int $id_nomina
     */
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
    'id_empleado'    => $this->request->getPost('id_empleado'),
    'mes'            => $this->request->getPost('mes'),
    'sueldo_base'    => $sueldo_base,
    'bonificacion'   => $bonificacion,
    'IGSS'           => $igss_calculado,
    'descuentos'     => $descuentos,
    'sueldo_liquido' => $sueldo_liquido,
];
// =========================================================
// 💡 DIAGNÓSTICO: DETENER Y MOSTRAR ERRORES
// =========================================================

// 1. Intentar validar los datos
if (!$this->nominaModel->validate($data)) {
    echo "<h1>❌ ERROR DE VALIDACIÓN</h1>";
    echo "<p>La nómina no se pudo guardar debido a:</p>";
    // Muestra todos los errores del modelo (incluyendo el error de clave foránea)
    dd($this->nominaModel->errors()); 
} 
// 2. Si la validación pasa, intentar GUARDAR y verificar el resultado
else {
    $guardado = $this->nominaModel->save($data);

    if ($guardado === false) {
        // Esto solo ocurre si hay un error de DB después de la validación
        echo "<h1>❌ ERROR DE BASE DE DATOS DESPUÉS DE LA VALIDACIÓN</h1>";
        // Muestra el último error de la base de datos
        dd($this->nominaModel->db->error()); 
    } else {
        // Éxito:
        $this->session->setFlashdata('success', 'Nómina calculada y registrada correctamente.');
        return redirect()->to(base_url('nomina'));
    }
}

// Finaliza el código aquí para evitar la redirección en caso de error
die();
        
        // =========================================================
        // 💡 CORRECCIÓN CLAVE: Usar la validación del modelo
        // =========================================================
        if (! $this->nominaModel->validate($data)) {
            // Si la validación falla (incluyendo el ID de empleado inexistente)
            $this->session->setFlashdata('errors', $this->nominaModel->errors());
            return redirect()->back()->withInput();
        }

        // 4. Actualizar en la base de datos
        $this->nominaModel->save($data);

        $this->session->setFlashdata('success', 'Registro de nómina actualizado correctamente.');
        return redirect()->to(base_url('nomina'));
    }
    
    /**
     * Elimina un registro de nómina. (D del CRUD)
     * @param int $id_nomina
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