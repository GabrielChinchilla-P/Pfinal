<?php namespace App\Models;

use CodeIgniter\Model;

class BonificacionModel extends Model
{
    protected $table      = 'bonificacion'; // Aseguramos el nombre correcto de la tabla (plural)
    protected $primaryKey = 'id_bonificacion';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Campos permitidos para inserción y actualización
    protected $allowedFields = [
        'id_empleado', 
        'ventas_mes', 
        'porcentaje', 
        'monto' // Este campo será calculado en el controlador
    ];

    // Desactivamos el uso de campos de tiempo
    protected $useTimestamps = false; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Une la tabla de Bonificaciones con la tabla de Empleados
     * para obtener el nombre completo del empleado en el listado.
     */
    public function getBonificacionesConEmpleado()
    {
        return $this->select('bonificacion.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado')
                    ->join('empleados e', 'e.id_empleado = bonificacion.id_empleado')
                    ->findAll();
    }

    /**
     * Función de búsqueda con JOINs que permite buscar por nombre o apellido del empleado.
     */
    public function buscarBonificaciones($searchQuery)
    {
        return $this->select('bonificacion.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado')
                    ->join('empleado e', 'e.id_empleado = bonificacion.id_empleado')
                    ->groupStart()
                        ->like('e.nombre', $searchQuery)
                        ->orLike('e.apellido', $searchQuery)
                        ->orLike('bonificacion.ventas_mes', $searchQuery)
                    ->groupEnd()
                    ->findAll();
    }
}