<?php 
// APPPATH/Models/InformeGastoModel.php

namespace App\Models;

use CodeIgniter\Model;

class InformeGastoModel extends Model
{
    protected $table            = 'informe_gastos';
    protected $primaryKey       = 'id_informe';
    protected $returnType       = 'array';
    protected $useAutoIncrement = false; 
    protected $useSoftDeletes   = false;

    // Campos que existen en la tabla informe_gastos
    protected $allowedFields = [
        'id_informe',
        'cod_empleado', 
        'cod_depto',    
        'nombre',
        'apellido',
        'departamento',
        'fecha_inicio',
        'fecha_fin',
        'fecha_visita',
        'descripcion',
        'otros',        // Gasto variable reportado
        'total'         // Total calculado
    ];

    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * 🔹 Obtiene todos los informes con datos relacionados del empleado y el departamento.
     * Se usa en el método index() del controlador.
     */
    public function getInformeConEmpleadoYDepartamento()
    {
        return $this->select('
                    informe_gastos.*,
                    e.nombre AS nombre_empleado,
                    e.apellido AS apellido_empleado,
                    d.descripcion AS nombre_departamento
                ')
                ->join('empleados e', 'e.cod_empleado = informe_gastos.cod_empleado', 'left')
                ->join('departamentos d', 'd.depto = informe_gastos.cod_depto', 'left')
                ->orderBy('informe_gastos.fecha_visita', 'DESC')
                ->findAll();
    }

    /**
     * 🔍 Buscar informes por nombre, apellido, departamento o fecha de visita.
     * Se usa en el método buscar() del controlador.
     */
    public function buscarInformes($searchQuery)
    {
        return $this->select('
                    informe_gastos.*,
                    e.nombre AS nombre_empleado,
                    e.apellido AS apellido_empleado,
                    d.descripcion AS nombre_departamento
                ')
                ->join('empleados e', 'e.cod_empleado = informe_gastos.cod_empleado', 'left')
                ->join('departamentos d', 'd.depto = informe_gastos.cod_depto', 'left')
                ->groupStart()
                    ->like('LOWER(e.nombre)', strtolower($searchQuery))
                    ->orLike('LOWER(e.apellido)', strtolower($searchQuery))
                    ->orLike('LOWER(d.descripcion)', strtolower($searchQuery))
                    ->orLike('informe_gastos.fecha_visita', $searchQuery)
                ->groupEnd()
                ->orderBy('informe_gastos.fecha_visita', 'DESC')
                ->findAll();
    }

    /**
     * ➕ Crear un nuevo informe de gastos.
     * Genera un ID único si no se proporciona.
     */
    public function crearInforme($data)
    {
        if (!isset($data['id_informe']) || empty($data['id_informe'])) {
            $data['id_informe'] = 'INF' . uniqid();
        }

        // Si el controlador no calculó el total, se usa 'otros'
        if (!isset($data['total'])) {
            $data['total'] = ($data['otros'] ?? 0); 
        }

        return $this->insert($data); 
    }

    /**
     * ✏️ Actualizar un informe de gastos existente.
     */
    public function actualizarInforme($id_informe, $data)
    {
        if (!isset($data['total']) && isset($data['otros'])) {
            $data['total'] = $data['otros']; 
        }

        return $this->update($id_informe, $data);
    }

    /**
     * 🗑️ Eliminar un informe de gastos.
     */
    public function eliminarInforme($id_informe)
    {
        return $this->delete($id_informe);
    }

    /**
     * 🔎 Obtener un informe por su ID.
     */
    public function getInformePorID($id_informe)
    {
        return $this->where('id_informe', $id_informe)->first();
    }
}