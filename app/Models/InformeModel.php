<?php namespace App\Models;

use CodeIgniter\Model;

class InformeModel extends Model
{
    protected $table = 'informe_gastos';          // Nombre de la tabla
    protected $primaryKey = 'id_gasto';           // Clave primaria

    protected $allowedFields = [
        'id_gasto',
        'id_empleado',
        'id_departamento',
        'fecha_visita',
        'alimentacion',
        'alojamiento',
        'combustible',
        'otros',
        'total_gasto'
    ];

    // 🔒 Protección de campos
    protected $useAutoIncrement = false;          // Si el ID lo manejas manualmente (string o numérico)
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = false;

    /**
     * 🔍 Retorna los gastos junto con la información del empleado.
     * Si la tabla empleados existe, se hace LEFT JOIN automáticamente.
     */
   public function getInformesConEmpleados()
{
    return $this->select('
            informe_gastos.*,
            empleados.nombre AS emp_nombre,
            empleados.apellido AS emp_apellido,
            departamentos.id_departamento AS emp_departamento
        ')
        ->join('empleados', 'empleados.id_empleado = informe_gastos.id_empleado', 'left')
        ->join('departamentos', 'departamentos.id_departamento = informe_gastos.id_departamento', 'left')
        ->orderBy('id_gasto', 'ASC')
        ->findAll();
}
    /**
     * 🔢 Calcula el total automáticamente antes de guardar.
     */
    protected function beforeInsert(array $data)
    {
        if (isset($data['data'])) {
            $data['data']['total_gasto'] =
                ($data['data']['alimentacion'] ?? 0) +
                ($data['data']['alojamiento'] ?? 0) +
                ($data['data']['combustible'] ?? 0) +
                ($data['data']['otros'] ?? 0);
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (isset($data['data'])) {
            $data['data']['total_gasto'] =
                ($data['data']['alimentacion'] ?? 0) +
                ($data['data']['alojamiento'] ?? 0) +
                ($data['data']['combustible'] ?? 0) +
                ($data['data']['otros'] ?? 0);
        }
        return $data;
    }
}