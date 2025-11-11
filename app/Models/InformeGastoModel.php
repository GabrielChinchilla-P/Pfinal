<?php

namespace App\Models;

use CodeIgniter\Model;

class InformeGastoModel extends Model
{
    protected $table = 'informes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_informe', 'cod_empleado', 'nombre', 'apellido',
        'departamento', 'fecha_inicio', 'fecha_fin', 'fecha_visita',
        'cod_depto', 'descripcion', 'otros', 'total',
        'alimentacion', 'alojamiento', 'combustible'
    ];

    /** Obtener todos los informes con datos relacionados */
    public function getInformeConEmpleadoYDepartamento()
    {
        return $this->select('informes.*, empleados.nombre AS nombre_empleado, empleados.apellido, departamentos.descripcion AS departamento')
                    ->join('empleados', 'empleados.cod_empleado = informes.cod_empleado', 'left')
                    ->join('departamentos', 'departamentos.cod_depto = informes.cod_depto', 'left')
                    ->findAll();
    }

    /** Buscar informes por nombre o rango de fechas */
    public function buscarInformes($q = null, $fecha_inicio = null, $fecha_fin = null)
    {
        $builder = $this->select('informes.*, empleados.nombre AS nombre_empleado, empleados.apellido, departamentos.descripcion AS departamento')
                        ->join('empleados', 'empleados.cod_empleado = informes.cod_empleado', 'left')
                        ->join('departamentos', 'departamentos.cod_depto = informes.cod_depto', 'left');

        if (!empty($q)) {
            $builder->groupStart()
                    ->like('empleados.nombre', $q)
                    ->orLike('empleados.apellido', $q)
                    ->orLike('departamentos.descripcion', $q)
                    ->groupEnd();
        }

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $builder->where('informes.fecha_visita >=', $fecha_inicio)
                    ->where('informes.fecha_visita <=', $fecha_fin);
        } elseif (!empty($fecha_inicio)) {
            $builder->where('informes.fecha_visita', $fecha_inicio);
        }

        return $builder->findAll();
    }

    /** Crear informe */
    public function crearInforme($data)
    {
        return $this->insert($data);
    }

    /** Obtener informe por ID */
    public function getInformePorID($id)
    {
        return $this->find($id);
    }

    /** Actualizar informe */
    public function actualizarInforme($id, $data)
    {
        return $this->update($id, $data);
    }

    /** Eliminar informe */
    public function eliminarInforme($id)
    {
        return $this->delete($id);
    }
}