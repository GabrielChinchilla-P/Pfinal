<?php namespace App\Controllers;

use App\Models\DepartamentosModel;
use CodeIgniter\Controller;

class Departamentos extends Controller
{
    protected $departamentosModel;

    public function __construct()
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

}