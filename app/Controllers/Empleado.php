<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EmpleadoModel;
use App\Models\UserModel; // Asumo que tienes un UserModel para casos donde lo necesites

class Empleado extends Controller 
{
    protected $empleadoModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->empleadoModel = new EmpleadoModel();
        // Usamos UserModel si lo tienes, sino ignora esta línea. Usaremos la DB directamente.
        $this->userModel = new UserModel();
        $this->session = session();
    }

    /**
     * Muestra la lista de registros de empleados con capacidad de búsqueda. (R del CRUD)
     */
    public function index()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado. No tienes permisos para ver Empleados.');
            return redirect()->to(base_url('menu')); 
        }
        
        $searchQuery = $this->request->getGet('q'); 
        
        if ($searchQuery) {
            $empleados = $this->empleadoModel->select('empleados.*, usuarios.usuario as nombre_usuario')
                                        ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario')
                                        ->orLike('empleados.nombre', $searchQuery)
                                        ->orLike('empleados.apellido', $searchQuery)
                                        ->orLike('empleados.dpi', $searchQuery)
                                        ->orderBy('empleados.apellido', 'ASC')
                                        ->findAll();
        } else {
            $empleados = $this->empleadoModel->getEmpleadosConUsuario();
        }


        $data = [
            'title'       => 'Gestión de Empleados',
            'empleados'   => $empleados, 
            'searchQuery' => $searchQuery,
        ];

        return view('empleado/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo empleado. (C del CRUD)
     */
    public function create()
{
    // Cargar el Form Helper para habilitar funciones como set_value()
    helper(['form']); // <--- AÑADIR ESTA LÍNEA

    if ($this->session->get('rol') !== 'admin') {
        $this->session->setFlashdata('msg_error', 'Acceso denegado.');
        return redirect()->to(base_url('menu'));
    }

    // Obtener la lista de usuarios que NO están asignados a un empleado
    $usuariosLibres = $this->empleadoModel->getUsuariosLibres();
    
    $data = [
        'title'          => 'Registrar Nuevo Empleado',
        'usuariosLibres' => $usuariosLibres,
        'validation'     => \Config\Services::validation(),
    ];
    
    // Asumiendo que esta es la línea donde se carga la vista
    return view('empleado/create', $data); 
}
    
    /**
     * Guarda el nuevo registro de empleado. (C del CRUD)
     */
    public function store()
    {
        if ($this->session->get('rol') !== 'admin') {
            $this->session->setFlashdata('msg', 'Acceso denegado.');
            return redirect()->to(base_url('menu'));
        }

        if (! $this->validate([
            'nombre'       => 'required|max_length[100]',
            'apellido'     => 'required|max_length[100]',
            'dpi'          => 'required|max_length[20]|is_unique[empleados.dpi]',
            'puesto'       => 'required|max_length[100]',
            'sueldo_base'  => 'required|numeric|greater_than[0]',
            'id_usuario'   => 'required|is_natural_no_zero|is_unique[empleados.id_usuario]',
        ])) {
            return redirect()->back()->withInput();
        }

        $this->empleadoModel->save([
            'nombre'       => $this->request->getPost('nombre'),
            'apellido'     => $this->request->getPost('apellido'),
            'dpi'          => $this->request->getPost('dpi'),
            'puesto'       => $this->request->getPost('puesto'),
            'sueldo_base'  => $this->request->getPost('sueldo_base'),
            'id_usuario'   => $this->request->getPost('id_usuario'),
        ]);

        $this->session->setFlashdata('success', 'Empleado registrado correctamente.');
        return redirect()->to(base_url('empleado'));
    }

    /**
     * Muestra el formulario para editar un empleado. (U del CRUD)
     */
    public function edit($id_empleado = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_empleado === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('empleado'));
        }

        $empleado = $this->empleadoModel->find($id_empleado);
        if (!$empleado) {
            $this->session->setFlashdata('msg', 'Registro de empleado no encontrado.');
            return redirect()->to(base_url('empleado'));
        }

        // Obtener todos los usuarios.
        // Incluimos al usuario actual del empleado en la lista (si su id_usuario no es null)
        $usuariosTodos = $this->userModel->findAll(); 
        
        // También obtenemos la lista de usuarios libres para el select
        $usuariosLibres = $this->empleadoModel->getUsuariosLibres();
        
        // Fusionamos la lista libre con el usuario asignado actualmente, si es necesario
        $listaUsuarios = array_merge($usuariosLibres, 
            $this->userModel->where('id_usuario', $empleado['id_usuario'])->findAll()
        );
        
        $data = [
            'title'     => 'Editar Empleado: ' . $empleado['nombre'] . ' ' . $empleado['apellido'],
            'empleado'  => $empleado,
            'usuarios'  => $listaUsuarios,
            'validation' => \Config\Services::validation(),
        ];

        return view('empleado/edit', $data);
    }
    
    /**
     * Procesa la actualización de un registro de empleado. (U del CRUD)
     */
    public function update($id_empleado = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_empleado === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('empleado'));
        }

        $empleadoActual = $this->empleadoModel->find($id_empleado);
        if (!$empleadoActual) {
            $this->session->setFlashdata('msg', 'Registro de empleado no encontrado.');
            return redirect()->to(base_url('empleado'));
        }
        
        // Reglas de validación, ignorando el DPI y el ID_USUARIO si no cambian
        $rules = [
            'nombre'      => 'required|max_length[100]',
            'apellido'    => 'required|max_length[100]',
            'puesto'      => 'required|max_length[100]',
            'sueldo_base' => 'required|numeric|greater_than[0]',
        ];
        
        // Regla condicional para DPI (debe ser único, excepto para el registro actual)
        if ($empleadoActual['dpi'] !== $this->request->getPost('dpi')) {
            $rules['dpi'] = 'required|max_length[20]|is_unique[empleados.dpi]';
        } else {
            $rules['dpi'] = 'required|max_length[20]';
        }
        
        // Regla condicional para id_usuario (debe ser único, excepto para el registro actual)
        if ((int)$empleadoActual['id_usuario'] !== (int)$this->request->getPost('id_usuario')) {
            $rules['id_usuario'] = 'required|is_natural_no_zero|is_unique[empleados.id_usuario]';
        } else {
             $rules['id_usuario'] = 'required|is_natural_no_zero';
        }


        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }
        
        // Preparar datos para la actualización
        $data = [
            'id_empleado'  => $id_empleado,
            'nombre'       => $this->request->getPost('nombre'),
            'apellido'     => $this->request->getPost('apellido'),
            'dpi'          => $this->request->getPost('dpi'),
            'puesto'       => $this->request->getPost('puesto'),
            'sueldo_base'  => $this->request->getPost('sueldo_base'),
            'id_usuario'   => $this->request->getPost('id_usuario'),
        ];
        
        $this->empleadoModel->save($data);

        $this->session->setFlashdata('success', 'Registro de empleado actualizado correctamente.');
        return redirect()->to(base_url('empleado'));
    }
    
    /**
     * Elimina un registro de empleado. (D del CRUD)
     */
    public function delete($id_empleado = null)
    {
        if ($this->session->get('rol') !== 'admin' || $id_empleado === null) {
            $this->session->setFlashdata('msg', 'Acceso denegado o registro no válido.');
            return redirect()->to(base_url('empleado'));
        }

        if ($this->empleadoModel->delete($id_empleado)) {
            $this->session->setFlashdata('success', 'Registro de empleado eliminado con éxito.');
        } else {
            // Esto fallará si el empleado tiene registros de nómina (Foreign Key constraint)
            $this->session->setFlashdata('msg', 'Error al eliminar. Verifique que no tenga nóminas asociadas.');
        }

        return redirect()->to(base_url('empleado'));
    }
}