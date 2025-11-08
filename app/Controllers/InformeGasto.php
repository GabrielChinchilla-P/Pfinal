<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\InformeGastoModel;
use App\Models\EmpleadoModel;
use App\Models\DepartamentoModel;

class InformeGasto extends Controller
{
    protected $informeGastoModel;
    protected $empleadoModel;
    protected $departamentoModel;

    public function __construct()
    {
        // Cargar modelos
        $this->informeGastoModel = new InformeGastoModel();
        $this->empleadoModel = new EmpleadoModel();
        $this->departamentoModel = new DepartamentoModel();
        
        // Cargar el helper de URL y Formulario
        helper(['url', 'form']);
    }

    /**
     * Muestra la lista de todos los informes de gasto y maneja la búsqueda.
     */
    public function index()
    {
        $searchQuery = $this->request->getGet('q');
        
        // Usamos la función del modelo que trae los nombres relacionados
        if ($searchQuery) {
            $informes = $this->informeGastoModel->buscarInformes($searchQuery);
        } else {
            $informes = $this->informeGastoModel->getInformeConEmpleadoYDepartamento();
        }

        $data = [
            'title'         => 'Informes de Gastos',
            'informes'      => $informes,
            'searchQuery'   => $searchQuery,
        ];

        return view('informegasto/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo informe.
     */
    public function create()
    {
        $data = [
            'title' => 'Registrar Nuevo Informe de Gasto',
            // Necesitamos pasar los listados de empleados y departamentos a la vista
            'empleados'     => $this->empleadoModel->findAll(),
            'departamentos' => $this->departamentoModel->findAll(),
        ];
        return view('informegasto/create', $data);
    }

    /**
     * Procesa y guarda un nuevo registro de informe de gasto, calculando el total.
     */
    public function store()
    {
        // 1. Definir reglas de validación
        $rules = [
            'id_empleado'       => 'required|integer',
            'id_departamento'   => 'required|integer',
            'fecha_visita'      => 'required|valid_date',
            'alimentacion'      => 'permit_empty|numeric|greater_than_equal_to[0]',
            'alojamiento'       => 'permit_empty|numeric|greater_than_equal_to[0]',
            'combustible'       => 'permit_empty|numeric|greater_than_equal_to[0]',
            'otros'             => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        // 2. Ejecutar validación
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Obtener los valores de gasto (asegurando que sean float o 0)
        $alimentacion = (float)$this->request->getPost('alimentacion') ?: 0;
        $alojamiento  = (float)$this->request->getPost('alojamiento') ?: 0;
        $combustible  = (float)$this->request->getPost('combustible') ?: 0;
        $otros        = (float)$this->request->getPost('otros') ?: 0;
        
        // 4. Calcular el total
        $total_gasto = $alimentacion + $alojamiento + $combustible + $otros;

        // 5. Preparar datos para guardar
        $data = [
            'id_empleado'       => $this->request->getPost('id_empleado'),
            'id_departamento'   => $this->request->getPost('id_departamento'),
            'fecha_visita'      => $this->request->getPost('fecha_visita'),
            'alimentacion'      => $alimentacion,
            'alojamiento'       => $alojamiento,
            'combustible'       => $combustible,
            'otros'             => $otros,
            'total_gasto'       => $total_gasto, // Campo calculado
        ];

        // 6. Guardar en la base de datos
        $this->informeGastoModel->save($data);

        // 7. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('informegasto'))->with('success', 'Informe de Gasto registrado y total calculado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un informe existente.
     * @param int $id El ID del informe a editar.
     */
    public function edit($id = null)
    {
        // 1. Buscar el informe
        $informe = $this->informeGastoModel->find($id);

        if (!$informe) {
            return redirect()->to(base_url('informegasto'))->with('error', 'Informe de Gasto no encontrado.');
        }

        $data = [
            'title'         => 'Editar Informe de Gasto',
            'informe'       => $informe,
            // Necesitamos pasar los listados de empleados y departamentos a la vista
            'empleados'     => $this->empleadoModel->findAll(),
            'departamentos' => $this->departamentoModel->findAll(),
        ];

        return view('informegasto/edit', $data);
    }

    /**
     * Procesa y actualiza un registro de informe de gasto, calculando el total.
     * @param int $id El ID del informe a actualizar.
     */
    public function update($id = null)
    {
        // 1. Buscar el informe actual
        $informe = $this->informeGastoModel->find($id);

        if (!$informe) {
            return redirect()->to(base_url('informegasto'))->with('error', 'Informe de Gasto no encontrado para actualizar.');
        }

        // 2. Definir reglas de validación (el empleado no debe ser editable en la vista, pero se valida)
        $rules = [
            'id_empleado'       => 'required|integer',
            'id_departamento'   => 'required|integer',
            'fecha_visita'      => 'required|valid_date',
            'alimentacion'      => 'permit_empty|numeric|greater_than_equal_to[0]',
            'alojamiento'       => 'permit_empty|numeric|greater_than_equal_to[0]',
            'combustible'       => 'permit_empty|numeric|greater_than_equal_to[0]',
            'otros'             => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        // 3. Ejecutar validación
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Obtener los valores de gasto (asegurando que sean float o 0)
        $alimentacion = (float)$this->request->getPost('alimentacion') ?: 0;
        $alojamiento  = (float)$this->request->getPost('alojamiento') ?: 0;
        $combustible  = (float)$this->request->getPost('combustible') ?: 0;
        $otros        = (float)$this->request->getPost('otros') ?: 0;
        
        // 5. Calcular el total
        $total_gasto = $alimentacion + $alojamiento + $combustible + $otros;

        // 6. Preparar datos para actualizar
        $data = [
            'id_gasto'          => $id, // ID para actualizar el registro correcto
            'id_empleado'       => $this->request->getPost('id_empleado'),
            'id_departamento'   => $this->request->getPost('id_departamento'),
            'fecha_visita'      => $this->request->getPost('fecha_visita'),
            'alimentacion'      => $alimentacion,
            'alojamiento'       => $alojamiento,
            'combustible'       => $combustible,
            'otros'             => $otros,
            'total_gasto'       => $total_gasto, // Campo calculado
        ];

        // 7. Actualizar en la base de datos
        $this->informeGastoModel->save($data);

        // 8. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('informegasto'))->with('success', 'Informe de Gasto actualizado exitosamente.');
    }

    /**
     * Elimina un registro de informe de gasto.
     * @param int $id El ID del informe a eliminar.
     */
    public function delete($id = null)
    {
        // 1. Buscar el informe
        $informe = $this->informeGastoModel->find($id);

        if (!$informe) {
            return redirect()->to(base_url('informegasto'))->with('error', 'Informe de Gasto no encontrado para eliminar.');
        }

        // 2. Eliminar el registro
        $this->informeGastoModel->delete($id);

        // 3. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('informegasto'))->with('success', 'Informe de Gasto eliminado exitosamente.');
    }
}