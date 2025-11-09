<?php namespace App\Models;

use CodeIgniter\Model;

class DepartamentosModel extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'depto';
    protected $allowedFields = [
        'depto', 'descripcion', 'distancia', 'alojamiento', 'combustible', 'alimentacion'
    ];
}