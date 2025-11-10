<?php namespace App\Models;

use CodeIgniter\Model;

class BonificacionModel extends Model
{
    protected $table      = 'bonificacion';
    protected $primaryKey = 'id_visitador';
    protected $allowedFields = [
        'id_visitador', 'nombre_visitador', 'ventas_totales', 'bonificacion'
    ];
}

   