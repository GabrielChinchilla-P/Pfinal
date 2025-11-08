<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BonificacionModel;
use App\Models\EmpleadoModel;

class Bonificacion extends Controller
{
    protected $bonificacionModel;
    protected $empleadoModel;

    public function __construct()
    {
        // Cargar modelos
        $this->bonificacionModel = new BonificacionModel();
        $this->empleadoModel = new EmpleadoModel();
        
        // Cargar el helper de URL y Formulario
        helper(['url', 'form']);
    }

    /**
     * Muestra la lista de todas las bonificaciones y maneja la búsqueda.
     */
    public function index()
    {
        $searchQuery = $this->request->getGet('q');
        
        if ($searchQuery) {
            $bonificaciones = $this->bonificacionModel->buscarBonificaciones($searchQuery);
        } else {
            $bonificaciones = $this->bonificacionModel->getBonificacionesConEmpleado();
        }

        $data = [
            'title'         => 'Bonificaciones de Empleados',
            'bonificaciones'=> $bonificaciones,
            'searchQuery'   => $searchQuery,
        ];

        return view('bonificacion/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de bonificación.
     */
    public function create()
    {
        $data = [
            'title'     => 'Registrar Nueva Bonificación',
            // Necesitamos la lista de empleados para el selector
            'empleados' => $this->empleadoModel->findAll(),
            'bonificacion' => null // Indica que es una operación de creación
        ];
        // Usamos la misma vista de formulario para crear y editar
        return view('bonificacion/form', $data);
    }

    /**
     * Procesa y guarda un nuevo registro de bonificación, calculando el monto.
     */
    public function store()
    {
        // 1. Definir reglas de validación
        $rules = [
            'id_empleado'   => 'required|integer',
            'ventas_mes'    => 'required|numeric|greater_than_equal_to[0]',
            'porcentaje'    => 'required|numeric|greater_than[0]', // El porcentaje debe ser mayor a 0
        ];

        // 2. Ejecutar validación
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Obtener y convertir datos a tipo numérico
        $ventas_mes = (float)$this->request->getPost('ventas_mes');
        $porcentaje = (float)$this->request->getPost('porcentaje');
        
        // 4. Calcular el monto: Monto = Ventas * (Porcentaje / 100)
        // Se asume que el usuario ingresa un porcentaje, por ejemplo, 10 (que es 10%)
        $monto = $ventas_mes * ($porcentaje / 100);

        // 5. Preparar datos para guardar
        $data = [
            'id_empleado'   => $this->request->getPost('id_empleado'),
            'ventas_mes'    => $ventas_mes,
            'porcentaje'    => $porcentaje,
            'monto'         => $monto, // Campo calculado
        ];

        // 6. Guardar en la base de datos
        $this->bonificacionModel->save($data);

        // 7. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('bonificacion'))->with('success', 'Bonificación registrada y monto calculado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un registro existente.
     * @param int $id El ID de la bonificación a editar.
     */
    public function edit($id = null)
    {
        $bonificacion = $this->bonificacionModel->find($id);

        if (!$bonificacion) {
            return redirect()->to(base_url('bonificacion'))->with('error', 'Bonificación no encontrada.');
        }

        $data = [
            'title'         => 'Editar Bonificación',
            'empleados'     => $this->empleadoModel->findAll(),
            'bonificacion'  => $bonificacion,
        ];

        return view('bonificacion/form', $data);
    }

    /**
     * Procesa y actualiza un registro de bonificación, recalculando el monto.
     * @param int $id El ID de la bonificación a actualizar.
     */
    public function update($id = null)
    {
        // 1. Validar existencia
        $bonificacion = $this->bonificacionModel->find($id);
        if (!$bonificacion) {
            return redirect()->to(base_url('bonificacion'))->with('error', 'Bonificación no encontrada para actualizar.');
        }

        // 2. Definir reglas de validación
        $rules = [
            'id_empleado'   => 'required|integer',
            'ventas_mes'    => 'required|numeric|greater_than_equal_to[0]',
            'porcentaje'    => 'required|numeric|greater_than[0]',
        ];

        // 3. Ejecutar validación
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Obtener y convertir datos a tipo numérico
        $ventas_mes = (float)$this->request->getPost('ventas_mes');
        $porcentaje = (float)$this->request->getPost('porcentaje');
        
        // 5. Calcular el monto
        $monto = $ventas_mes * ($porcentaje / 100);

        // 6. Preparar datos para actualizar
        $data = [
            'id_bonificacion' => $id, // ID para actualizar el registro correcto
            'id_empleado'     => $this->request->getPost('id_empleado'),
            'ventas_mes'      => $ventas_mes,
            'porcentaje'      => $porcentaje,
            'monto'           => $monto, // Campo calculado
        ];

        // 7. Actualizar en la base de datos
        $this->bonificacionModel->save($data);

        // 8. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('bonificacion'))->with('success', 'Bonificación actualizada exitosamente.');
    }

    /**
     * Elimina un registro de bonificación.
     * @param int $id El ID de la bonificación a eliminar.
     */
    public function delete($id = null)
    {
        // 1. Buscar la bonificación
        $bonificacion = $this->bonificacionModel->find($id);

        if (!$bonificacion) {
            return redirect()->to(base_url('bonificacion'))->with('error', 'Bonificación no encontrada para eliminar.');
        }

        // 2. Eliminar el registro
        $this->bonificacionModel->delete($id);

        // 3. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('bonificacion'))->with('success', 'Bonificación eliminada exitosamente.');
    }
}