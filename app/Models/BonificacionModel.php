<?php

namespace App\Models;

use CodeIgniter\Model;

class BonificacionModel extends Model
{
    protected $table = 'bonificaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_visitador',
        'nombre_visitador',
        'ventas_totales',
        'bonificacion'
    ];
}