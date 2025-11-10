<?php namespace App\Models;

use CodeIgniter\Model;

class EmpleadoModel extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'cod_empleado';
    protected $returnType = 'array';
    protected $useAutoIncrement = false; // porque cod_empleado lo asignamos manualmente
    protected $allowedFields = ['cod_empleado', 'nombre', 'apellido', 'departamento', 'fecha_ingreso'];
    protected $useTimestamps = false;
}