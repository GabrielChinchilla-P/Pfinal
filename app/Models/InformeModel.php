<?php namespace App\Models;

use CodeIgniter\Model;

class InformeModel extends Model
{
    // Nombre de la tabla principal
    protected $table = 'informe_gastos';

    // Clave primaria
    protected $primaryKey = 'id_informe';

    // Tipo de retorno
    protected $returnType = 'array';

    // Campos permitidos para insertar/actualizar
    protected $allowedFields = [
        'id_informe',
        'cod_empleado',
        'fecha_inicio',
        'fecha_fin',
        'fecha_visita',
        'cod_depto',
        'descripcion',
        'otros',
        'total'
    ];

    // ✅ Función para obtener los informes junto con los datos del empleado (JOIN)
    public function getInformesConEmpleados()
    {
        return $this->select('
                informe_gastos.id_informe,
                informe_gastos.cod_empleado,
                informe_gastos.fecha_inicio,
                informe_gastos.fecha_fin,
                informe_gastos.fecha_visita,
                informe_gastos.cod_depto,
                informe_gastos.descripcion,
                informe_gastos.otros,
                informe_gastos.total,
                empleados.nombre AS emp_nombre,
                empleados.apellido AS emp_apellido,
                empleados.departamento AS emp_departamento
            ')
            ->join('empleados', 'empleados.cod_empleado = informe_gastos.cod_empleado')
            ->orderBy('informe_gastos.id_informe', 'DESC')
            ->findAll();
    }
}