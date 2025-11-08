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

    // Reglas de validación añadidas previamente
    protected $validationRules = [
        'id_empleado'  => 'required|is_not_unique[empleados.id_empleado]', // VALIDACIÓN CONTRA EMPLEADOS
        // ... otras reglas ...
    ];
    
    protected $validationMessages = [
        // ... mensajes de validación ...
    ];

    /**
     * Obtiene la nómina realizando el JOIN correcto a Empleados y luego a Usuarios.
     * 💡 CORRECCIÓN CLAVE: El JOIN fue cambiado para reflejar la estructura DB.
     */
    public function getNominaConEmpleado()
    {
        return $this->db->table($this->table)
            ->select('
                nomina.*, 
                empleados.nombre as nombre_empleado, 
                usuarios.usuario as nombre_usuario
            ')
            // 1. JOIN de Nomina a Empleados (Relación principal)
            ->join('empleados', 'empleados.id_empleado = nomina.id_empleado') 
            // 2. JOIN de Empleados a Usuarios (Para obtener el nombre de usuario/login)
            ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario') // Asumo que empleados.id_usuario referencia a usuarios.id_usuario
            
            ->orderBy('nomina.mes', 'DESC')
            ->get()
            ->getResultArray();
    }
}