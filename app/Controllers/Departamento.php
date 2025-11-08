<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DepartamentoModel;

class Departamento extends Controller
{
    protected $departamentoModel;

    public function __construct()
    {
        // Cargar el modelo en el constructor
        $this->departamentoModel = new DepartamentoModel();
        // Cargar el helper de URL y Formulario para las vistas y el controlador
        helper(['url', 'form']);
    }

    /**
     * Muestra la lista de todos los departamentos y maneja la búsqueda.
     */
    public function index()
    {
        $searchQuery = $this->request->getGet('q');
        
        if ($searchQuery) {
            $departamentos = $this->departamentoModel->buscar($searchQuery);
        } else {
            $departamentos = $this->departamentoModel->findAll();
        }

        $data = [
            'title'         => 'Gestión de Departamentos',
            'departamentos' => $departamentos,
            'searchQuery'   => $searchQuery,
        ];

        return view('departamento/index', $data);
    }

    /**
     * Muestra el formulario para crear un nuevo departamento.
     */
    public function create()
    {
        $data = [
            'title' => 'Crear Nuevo Departamento'
        ];
        return view('departamento/create', $data);
    }

    /**
     * Procesa y guarda un nuevo registro de departamento.
     */
    public function store()
    {
        // 1. Definir reglas de validación
        $rules = [
            'nombre_departamento' => 'required|min_length[3]|max_length[150]|is_unique[departamentos.nombre_departamento]',
            'distancia_km'        => 'required|numeric|greater_than_equal_to[0]',
        ];

        // 2. Ejecutar validación
        if (!$this->validate($rules)) {
            // Si la validación falla, regresa al formulario con los errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Preparar datos para guardar
        $data = [
            'nombre_departamento' => $this->request->getPost('nombre_departamento'),
            'distancia_km'        => $this->request->getPost('distancia_km'),
        ];

        // 4. Guardar en la base de datos
        $this->departamentoModel->save($data);

        // 5. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('departamento'))->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un departamento existente.
     * @param int $id El ID del departamento a editar.
     */
    public function edit($id = null)
    {
        // 1. Buscar el departamento
        $departamento = $this->departamentoModel->find($id);

        if (!$departamento) {
            // Si no encuentra, redirigir con error
            return redirect()->to(base_url('departamento'))->with('error', 'Departamento no encontrado.');
        }

        $data = [
            'title'        => 'Editar Departamento',
            'departamento' => $departamento,
        ];

        return view('departamento/edit', $data);
    }

    /**
     * Procesa y actualiza un registro de departamento.
     * @param int $id El ID del departamento a actualizar.
     */
    public function update($id = null)
    {
        // 1. Obtener el departamento actual para la validación 'is_unique'
        $departamento = $this->departamentoModel->find($id);

        if (!$departamento) {
            return redirect()->to(base_url('departamento'))->with('error', 'Departamento no encontrado para actualizar.');
        }

        // 2. Definir reglas de validación (excluyendo el nombre actual si no cambia)
        $rules = [
            'nombre_departamento' => "required|min_length[3]|max_length[150]|is_unique[departamentos.nombre_departamento,id_departamento,{$id}]",
            'distancia_km'        => 'required|numeric|greater_than_equal_to[0]',
        ];

        // 3. Ejecutar validación
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Preparar datos para actualizar
        $data = [
            'id_departamento'     => $id,
            'nombre_departamento' => $this->request->getPost('nombre_departamento'),
            'distancia_km'        => $this->request->getPost('distancia_km'),
        ];

        // 5. Actualizar en la base de datos
        $this->departamentoModel->save($data);

        // 6. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('departamento'))->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Elimina un registro de departamento.
     * @param int $id El ID del departamento a eliminar.
     */
    public function delete($id = null)
    {
        // 1. Buscar el departamento
        $departamento = $this->departamentoModel->find($id);

        if (!$departamento) {
            return redirect()->to(base_url('departamento'))->with('error', 'Departamento no encontrado para eliminar.');
        }

        // 2. Eliminar el registro
        $this->departamentoModel->delete($id);

        // 3. Redireccionar con mensaje de éxito
        return redirect()->to(base_url('departamento'))->with('success', 'Departamento eliminado exitosamente.');
    }
}