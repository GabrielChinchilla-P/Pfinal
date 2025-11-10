<?php namespace App\Controllers;

use App\Models\BonificacionModel;
use CodeIgniter\Controller;

class Bonificacion extends Controller
{
    protected $bonificacionModel;

    public function __construct()
    {
        $this->bonificacionModel = new BonificacionModel();
    }

    // 📋 Listar registros
    public function index()
    {
        $data['bonificacion'] = $this->bonificacionModel->findAll();
        echo view('templates/header');
        echo view('bonificacion/index', $data);
        echo view('templates/footer');
    }

    // 🔍 Buscar
    public function buscar()
    {
        $busqueda = $this->request->getGet('q');
        if ($busqueda) {
            $data['bonificacion'] = $this->bonificacionModel
                ->like('id_visitador', $busqueda)
                ->orLike('nombre_visitador', $busqueda)
                ->findAll();
        } else {
            $data['bonificacion'] = $this->bonificacionModel->findAll();
        }

        echo view('templates/header');
        echo view('bonificacion/index', $data);
        echo view('templates/footer');
    }

    // 🟢 Guardar nuevo
    public function store()
    {
        $data = $this->request->getPost([
            'id_visitador', 'nombre_visitador', 'ventas_totales'
        ]);

        $ventas = (float)$data['ventas_totales'];

        // Calcular bonificación automáticamente
        if ($ventas >= 40000) {
            $data['bonificacion'] = $ventas * 0.15;
        } elseif ($ventas >= 25000) {
            $data['bonificacion'] = $ventas * 0.10;
        } else {
            $data['bonificacion'] = $ventas * 0.05;
        }

        $this->bonificacionModel->insert($data);

        if ($this->bonificacionModel->db->affectedRows() > 0) {
            return redirect()->to('/bonificacion')->with('success', 'Bonificación registrada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al guardar la bonificación.');
        }
    }

    // ✏️ Editar registro
    public function update($id)
    {
        $data = $this->request->getPost([
            'nombre_visitador', 'ventas_totales'
        ]);

        $ventas = (float)$data['ventas_totales'];

        if ($ventas >= 40000) {
            $data['bonificacion'] = $ventas * 0.15;
        } elseif ($ventas >= 25000) {
            $data['bonificacion'] = $ventas * 0.10;
        } else {
            $data['bonificacion'] = $ventas * 0.05;
        }

        $this->bonificacionModel->update($id, $data);

        if ($this->bonificacionModel->db->affectedRows() > 0) {
            return redirect()->to('/bonificacion')->with('success', 'Bonificación actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'No se realizaron cambios.');
        }
    }

    // ❌ Eliminar
    public function delete($id)
    {
        if ($this->bonificacionModel->delete($id)) {
            return redirect()->to('/bonificacion')->with('success', 'Bonificación eliminada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar la bonificación.');
        }
    }
}