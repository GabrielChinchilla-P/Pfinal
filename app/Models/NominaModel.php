<?php 
namespace App\Models;

use CodeIgniter\Model;

class NominaModel extends Model
{
    protected $table            = 'nomina'; 
    protected $primaryKey       = 'id_nomina'; 
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; 

    protected $allowedFields = [
        'id_empleado', 
        'mes', 
        'sueldo_base', 
        'bonificacion', 
        'IGSS', 
        'descuentos', 
        'sueldo_liquido'
    ]; 

    // ==========================================================
    // 💡 VERIFICACIÓN CRÍTICA: REGLAS Y MENSAJES DE VALIDACIÓN
    // ==========================================================
    protected $validationRules = [
        'id_empleado'    => 'required|integer', // 'integer' para asegurar que es un número
        'mes'            => 'required|max_length[10]', 
        'sueldo_base'    => 'required|numeric|greater_than[0]',
        'bonificacion'   => 'permit_empty|numeric|greater_than_equal_to[0]',
        'descuentos'     => 'permit_empty|numeric|greater_than_equal_to[0]',
    ];
    
    protected $validationMessages = [
        'id_empleado' => [
            'required' => 'Debe seleccionar un empleado.',
            'integer'  => 'El ID del empleado debe ser un número entero.',
            // Si necesitas validar la existencia, asegúrate de que el campo exista 
            // en la tabla de referencia (ej: 'is_not_unique[empleados.id_empleado]')
            // Si esta regla está causando el fallo, revísala cuidadosamente:
            // 'is_not_unique' => 'El empleado seleccionado no es válido o no existe en la base de datos.',
        ],
        'mes' => [
            'required'   => 'El mes es obligatorio.',
            'max_length' => 'El campo Mes no puede exceder 10 caracteres.'
        ],
        'sueldo_base' => [
            'required'     => 'El sueldo base es obligatorio.',
            'numeric'      => 'El sueldo base debe ser un número.',
            'greater_than' => 'El sueldo base debe ser mayor a cero.',
        ],
        // ... (otros mensajes si son necesarios)
    ];

    // ... (El método getNominaConEmpleado() corregido previamente)

    public function getNominaConEmpleado()
    {
        return $this->db->table($this->table)
            ->select('
                nomina.*, 
                empleados.nombre as nombre_empleado, 
                usuarios.usuario as nombre_usuario
            ')
            ->join('empleados', 'empleados.id_empleado = nomina.id_empleado') 
            ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario') 
            ->orderBy('nomina.mes', 'DESC')
            ->get()
            ->getResultArray();
    }
}