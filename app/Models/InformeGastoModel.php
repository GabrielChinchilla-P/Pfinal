<?php namespace App\Models;

use CodeIgniter\Model;

class InformeGastoModel extends Model
{
    // Nombre de la tabla corregido para que coincida con la base de datos (informe_gastos)
    protected $table      = 'informe_gastos';
    protected $primaryKey = 'id_gasto';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Campos permitidos para inserción y actualización
    protected $allowedFields = [
        'id_empleado', 
        'id_departamento', 
        'fecha_visita', 
        'alimentacion', 
        'alojamiento', 
        'combustible', 
        'otros', 
        'total_gasto'
    ];

    // Desactivamos el uso de campos de tiempo (created_at, updated_at)
    protected $useTimestamps = false; 

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Obtiene todos los informes de gasto, incluyendo el nombre completo del empleado 
     * y el nombre del departamento mediante JOINs.
     */
    public function getInformeConEmpleadoYDepartamento()
    {
        return $this->select('informe_gastos.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado, d.nombre_departamento')
                    // Join con la tabla de empleados
                    ->join('empleados e', 'e.id_empleado = informe_gastos.id_empleado')
                    // Join con la tabla de departamentos
                    ->join('departamentos d', 'd.id_departamento = informe_gastos.id_departamento')
                    ->findAll();
    }

    /**
     * Función de búsqueda con JOINs que permite buscar por nombre, apellido, departamento o fecha.
     * @param string $searchQuery El término de búsqueda.
     */
    public function buscarInformes($searchQuery)
    {
        return $this->select('informe_gastos.*, e.nombre AS nombre_empleado, e.apellido AS apellido_empleado, d.nombre_departamento')
                    ->join('empleados e', 'e.id_empleado = informe_gastos.id_empleado')
                    ->join('departamentos d', 'd.id_departamento = informe_gastos.id_departamento')
                    // Agrupamos las condiciones LIKE para un OR lógico
                    ->groupStart()
                        ->like('e.nombre', $searchQuery)
                        ->orLike('e.apellido', $searchQuery)
                        ->orLike('d.nombre_departamento', $searchQuery)
                        ->orLike('informe_gastos.fecha_visita', $searchQuery)
                    ->groupEnd()
                    ->findAll();
    }
}