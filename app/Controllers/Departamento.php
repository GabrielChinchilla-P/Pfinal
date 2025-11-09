<?php namespace App\Controllers;

use App\Models\DepartamentosModel;
use CodeIgniter\Controller;

class Departamentos extends Controller
{
    protected $departamentosModel;

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

    {
        $this->departamentosModel = new DepartamentosModel();
    }

    // 📄 Mostrar lista
    public function index()
    {
        $data['departamentos'] = $this->departamentosModel->findAll();
        echo view('templates/header');
        echo view('departamentos/index', $data);
        echo view('templates/footer');
    }
     // 🔍 Buscar departamentos
public function buscar()
{
    $query = $this->request->getGet('q'); // obtiene lo que el usuario escribió

    if ($query) {
        // Busca por código o descripción
        $departamentos = $this->departamentosModel
            ->like('depto', $query)
            ->orLike('descripcion', $query)
            ->findAll();
    } else {
        $departamentos = $this->departamentosModel->findAll();
    }

    // Retorna a la misma vista con los resultados
    return view('templates/header')
        . view('departamentos/index', ['departamentos' => $departamentos])
        . view('templates/footer');
}
// 🟢 Guardar
    public function store()
{
    $data = $this->request->getPost([
        'depto', 'descripcion', 'distancia', 'alojamiento', 'alimentacion'
    ]);

    $data['combustible'] = (float)$data['distancia'] * 30.54;

    $this->departamentosModel->insert($data);

    if ($this->departamentosModel->db->affectedRows() > 0) {
        return redirect()->to('/departamentos')->with('success', 'Departamento agregado correctamente.');
    } else {
        return redirect()->back()->with('error', 'No se realizaron cambios (verifique el código del departamento).');
    }
}

    // ✏️ Editar
    public function update($id)
    {
        $data = $this->request->getPost([
            'descripcion', 'distancia', 'alojamiento', 'alimentacion'
        ]);

        $data['combustible'] = (float)$data['distancia'] * 30.54;

        if ($this->departamentosModel->update($id, $data)) {
            return redirect()->to('/departamentos')->with('success', 'Departamento actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el departamento.');
        }
    }
    // ❌ Eliminar
    public function delete($id)
    {
        if ($this->departamentosModel->delete($id)) {
            return redirect()->to('/departamentos')->with('success', 'Departamento eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el departamento.');
        }
    }

}