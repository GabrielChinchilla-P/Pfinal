<?php namespace App\Models;

use CodeIgniter\Model;

class EmpleadosModel extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'cod_empleado';
    protected $allowedFields = [
        'cod_empleado', 'nombre', 'apellido', 'departamento', 'fecha_ingreso'
    ];
}