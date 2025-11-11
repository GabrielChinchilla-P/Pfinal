<?php
namespace App\Models;

use CodeIgniter\Model;

class InformeGastoModel extends Model
{
    protected $table            = 'informe_gastos';
    protected $primaryKey       = 'id_informe';
    protected $returnType       = 'array';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
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
        'alimentacion',
        'alojamiento',
        'combustible',
        'otros',
        'total'
    ];

    /**
     * 🔹 Obtener todos los informes con JOIN de empleados y departamentos
     */
    public function getInformeConEmpleadoYDepartamento()
    {
        return $this->select('informe_gastos.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado, d.descripcion AS nombre_departamento')
                    ->join('empleados e', 'e.cod_empleado = informe_gastos.cod_empleado', 'left')
                    ->join('departamentos d', 'd.depto = informe_gastos.cod_depto', 'left')
                    ->orderBy('informe_gastos.fecha_visita', 'DESC')
                    ->findAll();
    }

    /**
     * 🔍 Buscar informes por texto y rango de fechas
     */
    public function buscarInformes($searchQuery = null, $fechaInicio = null, $fechaFin = null)
    {
        $builder = $this->select('informe_gastos.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado, d.descripcion AS nombre_departamento')
                        ->join('empleados e', 'e.cod_empleado = informe_gastos.cod_empleado', 'left')
                        ->join('departamentos d', 'd.depto = informe_gastos.cod_depto', 'left');

        // Filtro de texto (nombre, apellido o departamento)
        if (!empty($searchQuery)) {
            $builder->groupStart()
                        ->like('e.nombre', $searchQuery)
                        ->orLike('e.apellido', $searchQuery)
                        ->orLike('d.descripcion', $searchQuery)
                    ->groupEnd();
        }

        // Filtro de rango de fechas
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $builder->where('informe_gastos.fecha_visita >=', $fechaInicio)
                    ->where('informe_gastos.fecha_visita <=', $fechaFin);
        } elseif (!empty($fechaInicio)) {
            $builder->where('informe_gastos.fecha_visita >=', $fechaInicio);
        } elseif (!empty($fechaFin)) {
            $builder->where('informe_gastos.fecha_visita <=', $fechaFin);
        }

        return $builder->orderBy('informe_gastos.fecha_visita', 'DESC')->findAll();
    }

    /**
     * Crear nuevo informe
     */
    public function crearInforme($data)
    {
        if (empty($data['id_informe'])) {
            $data['id_informe'] = 'INF' . uniqid();
        }

        if (!isset($data['total'])) {
            $data['total'] = ($data['alimentacion'] ?? 0) + ($data['alojamiento'] ?? 0)
                           + ($data['combustible'] ?? 0) + ($data['otros'] ?? 0);
        }

        return $this->insert($data);
    }

    /**
     * Actualizar informe existente
     */
    public function actualizarInforme($id_informe, $data)
    {
        if (!isset($data['total'])) {
            $data['total'] = ($data['alimentacion'] ?? 0) + ($data['alojamiento'] ?? 0)
                           + ($data['combustible'] ?? 0) + ($data['otros'] ?? 0);
        }

        return $this->update($id_informe, $data);
    }

    /**
     * Eliminar informe
     */
    public function eliminarInforme($id_informe)
    {
        return $this->delete($id_informe);
    }

    /**
     * Obtener un informe por su ID
     */
    public function getInformePorID($id_informe)
    {
        return $this->where('id_informe', $id_informe)->first();
    }
}