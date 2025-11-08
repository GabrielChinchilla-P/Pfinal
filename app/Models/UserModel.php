<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // A. Nombre de la tabla
    protected $table      = 'usuarios'; 
    // B. Clave Primaria
    protected $primaryKey = 'id_usuario'; // ¡Ajustado a 'id_usuario'!
    
    // C. Campos permitidos (¡Se ajusta a nombres de columna!)
    protected $allowedFields = [
        'nombre', 
        'correo', 
        'usuario', 
        'contrasena', // ¡Ajustado a 'contrasena'!
        'rol'
    ]; 
    
    // Puedes añadir estas propiedades si usas marcas de tiempo:
    protected $useTimestamps = false; 
    protected $createdField  = 'fecha_creacion';
    protected $updatedField  = 'fecha_actualizacion';
}