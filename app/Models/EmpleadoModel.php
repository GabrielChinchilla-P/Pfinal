<?php 
namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder; // Necesario para tipar el Closure

class EmpleadoModel extends Model
{
    /**
     * @var string Nombre de la tabla de la base de datos.
     */
    protected $table = 'empleados'; 
    
    /**
     * @var string Clave primaria de la tabla.
     */
    protected $primaryKey = 'id_empleado'; 

    /**
     * @var string El tipo de datos que se retorna.
     */
    protected $returnType = 'array';
    
    /**
     * @var bool Indica si se utiliza el "Soft Deletes".
     */
    protected $useSoftDeletes = false; 

    /**
     * @var array Campos de la base de datos permitidos para inserción/actualización.
     */
    protected $allowedFields = [
        'nombre', 
        'apellido', 
        'dpi', 
        'puesto', 
        'sueldo_base', 
        'id_usuario' // FK que apunta a la tabla de usuarios
    ]; 

    // --- Reglas de Validación (Añadidas) ---
    
    protected $validationRules = [
        // Asegura que el nombre, apellido, puesto y sueldo_base sean obligatorios.
        'nombre'      => 'required|max_length[100]',
        'apellido'    => 'required|max_length[100]',
        'puesto'      => 'required|max_length[100]',
        'sueldo_base' => 'required|numeric|greater_than[0]',
        
        // El DPI debe ser único y tener la longitud correcta (asumiendo 13 dígitos para Guatemala).
        'dpi'         => 'required|is_unique[empleados.dpi]|exact_length[13]', 
        
        // El id_usuario debe ser un entero, obligatorio y ÚNICO en la tabla 'empleados'.
        'id_usuario'  => 'required|integer|is_unique[empleados.id_usuario]',
    ];

    protected $validationMessages = [
        'id_usuario' => [
            'is_unique' => 'Este usuario ya se encuentra registrado como empleado.',
            'required'  => 'Debe asignar un usuario del sistema a este empleado.',
        ],
        'dpi' => [
            'is_unique'   => 'Ya existe un empleado con este número de DPI.',
            'exact_length'=> 'El campo DPI debe tener exactamente 13 dígitos.',
        ],
        // ... Puedes agregar más mensajes personalizados aquí
    ];

    // ----------------------------------------
    
    /**
     * Obtiene la lista completa de empleados con sus nombres de usuario.
     * * @return array
     */
    public function getEmpleadosConUsuario(): array
    {
        return $this->select('empleados.*, usuarios.usuario as nombre_usuario')
            ->join('usuarios', 'usuarios.id_usuario = empleados.id_usuario', 'inner')
            ->orderBy('empleados.apellido', 'ASC')
            ->findAll(); // findAll() es el método de Model que llama a get()->getResultArray()
    }
    
    /**
     * Obtiene los usuarios que aún NO han sido asignados como empleados.
     * * @return array
     */
   public function getUsuariosLibres(): array
{
    // Capturamos el nombre de la tabla (empleados) del modelo para usarlo dentro del Closure.
    $empleadosTable = $this->table; 

    // Se utiliza un Closure para construir la subconsulta.
    // Usamos 'use ($empleadosTable)' para pasar la variable al ámbito del Closure.
    return $this->db->table('usuarios')
        ->select('id_usuario, usuario') // Añadir el campo 'usuario' para referencia fácil
        ->whereNotIn('id_usuario', function (BaseBuilder $builder) use ($empleadosTable) {
            
            // Subconsulta: SELECT id_usuario FROM empleados
            $builder->select('id_usuario')
                    ->from($empleadosTable); 
        })
        ->orderBy('usuario', 'ASC')
        ->get()
        ->getResultArray();
}
}