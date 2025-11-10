<?php namespace App\Controllers;

use App\Models\EmpleadosModel;
use CodeIgniter\Controller;

class Empleados extends Controller
{
    protected $empleadosModel;

    public function __construct()
    {
        $this->empleadosModel = new EmpleadosModel();
    }

    // 📄 Listar
    public function index()
    {
        $data['empleados'] = $this->empleadosModel->findAll();
        echo view('templates/header');
        echo view('empleados/index', $data);
        echo view('templates/footer');
    }

    // 🔍 Buscar
    public function buscar()
    {
        $busqueda = $this->request->getGet('q');
        if ($busqueda) {
            $data['empleados'] = $this->empleadosModel
                ->like('cod_empleado', $busqueda)
                ->orLike('nombre', $busqueda)
                ->orLike('apellido', $busqueda)
                ->orLike('departamento', $busqueda)
                ->findAll();
        } else {
            $data['empleados'] = $this->empleadosModel->findAll();
        }

        echo view('templates/header');
        echo view('empleados/index', $data);
        echo view('templates/footer');
    }

    // 🟢 Guardar
    public function store()
{
    $data = $this->request->getPost([
        'cod_empleado', 'nombre', 'apellido', 'departamento', 'fecha_ingreso'
    ]);

    $this->empleadosModel->insert($data);

    if ($this->empleadosModel->db->affectedRows() > 0) {
        return redirect()->to('/empleados')->with('success', 'Empleado agregado correctamente.');
    } else {
        return redirect()->back()->with('error', 'No se realizaron cambios (verifique el código del empleado).');
    }
}

    // ✏️ Editar
    public function update($id)
    {
        $data = $this->request->getPost([
            'nombre', 'apellido', 'departamento', 'fecha_ingreso'
        ]);

        if ($this->empleadosModel->update($id, $data)) {
            return redirect()->to('/empleados')->with('success', 'Empleado actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el empleado.');
        }
    }
 // ❌ Eliminar
    public function delete($id)
    {
        if ($this->empleadosModel->delete($id)) {
            return redirect()->to('/empleados')->with('success', 'Empleado eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el empleado.');
        }
    }
}