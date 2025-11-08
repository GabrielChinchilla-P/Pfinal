<?php namespace App\Models;

use CodeIgniter\Model;

class DepartamentoModel extends Model
{
    protected $table      = 'departamentos';
    protected $primaryKey = 'id_departamento';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Campos permitidos para inserción y actualización
    protected $allowedFields = [
        'nombre_departamento', 
        'distancia_km'
    ];

    // Fechas
    protected $useTimestamps = false; // Ajustar si usas campos created_at/updated_at

    // Validaciones
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    // Función para búsqueda
    public function buscar($searchQuery)
    {
        return $this->like('nombre_departamento', $searchQuery)
                    ->orLike('distancia_km', $searchQuery)
                    ->findAll();
    }
}