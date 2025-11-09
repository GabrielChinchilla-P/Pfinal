<?php

namespace App\Models;

use CodeIgniter\Model;

class NominaModel extends Model
{
    // 🧾 Nombre de la tabla en la base de datos
    protected $table = 'nomina';

    // 🔑 Clave primaria
    protected $primaryKey = 'id_nomina';

    // 🛡️ Permitir autoincremento
    protected $useAutoIncrement = true;

    // 🧩 Campos que se pueden insertar o actualizar
    protected $allowedFields = [
        'id_empleado',
        'mes',
        'sueldo_base',
        'bonificacion',
        'IGSS',
        'descuentos',
        'sueldo_liquido'
    ];

    // ⚙️ Retornar los resultados como objetos
    protected $returnType = 'object';

    // 🔒 Validaciones automáticas
    protected $validationRules = [
        'id_empleado'    => 'required|integer',
        'mes'            => 'required|string|max_length[50]',
        'sueldo_base'    => 'required|decimal',
        'bonificacion'   => 'permit_empty|decimal',
        'IGSS'           => 'permit_empty|decimal',
        'descuentos'     => 'permit_empty|decimal',
        'sueldo_liquido' => 'permit_empty|decimal',
    ];

    // 📋 Mensajes de error personalizados
    protected $validationMessages = [
        'id_empleado' => [
            'required' => 'Debe seleccionar un empleado válido.'
        ],
        'mes' => [
            'required' => 'El campo "Mes" es obligatorio.'
        ],
        'sueldo_base' => [
            'required' => 'Debe ingresar el sueldo base del empleado.',
            'decimal'  => 'El sueldo base debe ser un número válido.'
        ],
    ];

    // 🚫 Sin validación automática al guardar
    protected $skipValidation = false;

    /**
     * 🔍 Obtiene todas las nóminas con datos de empleados y usuarios
     */
    public function getNominasConEmpleados()
    {
        return $this->select('
                nomina.id_nomina,
                nomina.mes,
                nomina.sueldo_base,
                nomina.bonificacion,
                nomina.IGSS,
                nomina.descuentos,
                nomina.sueldo_liquido,
                empleados.nombre AS nombre_empleado,
                empleados.apellido AS apellido_empleado,
                usuarios.usuario AS nombre_usuario
            ')
            ->join('empleados', 'empleados.id_empleado = nomina.id_empleado', 'left')
            ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario', 'left')
            ->orderBy('nomina.mes', 'DESC')
            ->findAll();
    }
}