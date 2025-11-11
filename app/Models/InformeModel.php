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

    // Campos que SÍ existen en la tabla informe_gastos
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
        'otros',        // <-- Gasto variable reportado
        'total'         // <-- Total calculado
    ];

    protected $useTimestamps = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * Obtiene todos los informes con datos de empleado y departamento
     */
public function getInformeConEmpleadoYDepartamento()
{
    return $this->select('informe_gastos.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado, d.descripcion AS nombre_departamento')
                 ->join('empleados e', 'e.cod_empleado = informe_gastos.cod_empleado')
                 ->join('departamentos d', 'd.depto = informe_gastos.cod_depto')
                 ->findAll();
}

    /**
     * Buscar informes por nombre, apellido, departamento o fecha de visita
     */
    public function buscarInformes($searchQuery)
    {
        return $this->select('informe_gastos.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado, d.descripcion AS nombre_departamento')
                    ->join('empleados e', 'e.cod_empleado = informe_gastos.cod_empleado')
                    ->join('departamentos d', 'd.depto = informe_gastos.cod_depto')
                    ->groupStart()
                        ->like('e.nombre', $searchQuery)
                        ->orLike('e.apellido', $searchQuery)
                        ->orLike('d.descripcion', $searchQuery)
                        ->orLike('informe_gastos.fecha_visita', $searchQuery)
                    ->groupEnd()
                    ->findAll();
    }

    /**
     * Crear un nuevo informe de gastos
     * Esta función **genera el ID** y utiliza el método nativo insert().
     */
    public function crearInforme($data)
    {
        // Generar id único si no se envía
        if (!isset($data['id_informe']) || empty($data['id_informe'])) {
            $data['id_informe'] = 'INF' . uniqid();
        }

        // Si el controlador no calculó el total (debería hacerlo), usamos solo 'otros'
        if (!isset($data['total'])) {
            $data['total'] = ($data['otros'] ?? 0); 
        }

        return $this->insert($data); 
    }
    /**
     * Actualizar un informe de gastos
     */
    public function actualizarInforme($id_informe, $data)
    {
        // El total ya debe venir calculado desde el controlador.
        // Si no se envía total, y sí 'otros', lo asumimos.
        if (!isset($data['total']) && isset($data['otros'])) {
             $data['total'] = $data['otros']; 
        }

        return $this->update($id_informe, $data);
    }

    /**
     * Eliminar un informe de gastos
     */
    public function eliminarInforme($id_informe)
    {
        return $this->delete($id_informe);
    }

    /**
     * Obtener un informe por ID
     */
    public function getInformePorID($id_informe)
    {
        return $this->where('id_informe', $id_informe)->first();
    }
}