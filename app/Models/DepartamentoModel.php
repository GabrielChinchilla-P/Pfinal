<?php 
// APPPATH/Models/DepartamentoModel.php

namespace App\Models;

use CodeIgniter\Model;

class DepartamentoModel extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'depto';
    protected $returnType = 'array';
    protected $useAutoIncrement = false; 
    protected $allowedFields = ['depto', 'descripcion', 'distancia', 'alojamiento', 'combustible', 'alimentacion'];
    protected $useTimestamps = false;
    
    /**
     * Obtiene los montos fijos de gastos asociados a un departamento para el cálculo del total.
     */
    public function obtenerCostosFijos($cod_depto)
    {
        return $this->select('alojamiento, combustible, alimentacion')
                    ->where('depto', $cod_depto)
                    ->first();
    }

    /**
     * Inserta todos los costos fijos de gastos para los departamentos de Guatemala.
     * Utiliza insertBatch() para inserción masiva.
     */
    public function insertarCostosFijosGuatemala()
    {
        // Datos de costos fijos de Guatemala (Arreglo corregido)
        $datos = [
            [
                'depto' => 1, 
                'descripcion' => 'Alta Verapaz', 
                'distancia' => 200.31, 
                'alojamiento' => 310.00, 
                'combustible' => 349.57, 
                'alimentacion' => 210.00
            ],
            [
                'depto' => 2, 
                'descripcion' => 'Baja Verapaz', 
                'distancia' => 105.22, 
                'alojamiento' => 450.00, 
                'combustible' => 183.62, 
                'alimentacion' => 210.00
            ],
            [
                'depto' => 3, 
                'descripcion' => 'Chimaltenango', 
                'distancia' => 87.79, 
                'alojamiento' => 200.00, 
                'combustible' => 153.21, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 4, 
                'descripcion' => 'Chiquimula', 
                'distancia' => 190.76, 
                'alojamiento' => 476.00, 
                'combustible' => 332.90, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 5, 
                'descripcion' => 'Petén', 
                'distancia' => 416.27, 
                'alojamiento' => 420.00, 
                'combustible' => 726.45, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 6, 
                'descripcion' => 'El Progreso', 
                'distancia' => 85.65, 
                'alojamiento' => 210.00, 
                'combustible' => 149.47, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 7, 
                'descripcion' => 'Escuintla', 
                'distancia' => 54.83, 
                'alojamiento' => 450.00, 
                'combustible' => 95.69, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 8, 
                'descripcion' => 'Guatemala', 
                'distancia' => 20.72, 
                'alojamiento' => 220.00, 
                'combustible' => 36.16, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 9, 
                'descripcion' => 'Huehuetenango', 
                'distancia' => 256.67, 
                'alojamiento' => 500.00, 
                'combustible' => 447.93, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 10, 
                'descripcion' => 'Izabal', 
                'distancia' => 264.11, 
                'alojamiento' => 550.00, 
                'combustible' => 460.91, 
                'alimentacion' => 210.00
            ],
            [
                'depto' => 11, 
                'descripcion' => 'Jalapa', 
                'distancia' => 104.56, 
                'alojamiento' => 450.00, 
                'combustible' => 182.47, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 12, 
                'descripcion' => 'Jutiapa', 
                'distancia' => 112.60, 
                'alojamiento' => 366.00, 
                'combustible' => 196.50, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 13, 
                'descripcion' => 'Quetzaltenango', 
                'distancia' => 250.84, 
                'alojamiento' => 531.00, 
                'combustible' => 437.75, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 14, 
                'descripcion' => 'Quiché', 
                'distancia' => 251.54, 
                'alojamiento' => 420.00, 
                'combustible' => 438.97, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 15, 
                'descripcion' => 'Retalhuleu', 
                'distancia' => 183.08, 
                'alojamiento' => 350.00, 
                'combustible' => 319.50, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 16, 
                'descripcion' => 'Sacatepéquez', 
                'distancia' => 36.51, 
                'alojamiento' => 200.00, 
                'combustible' => 63.72, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 17, 
                'descripcion' => 'San Marcos', 
                'distancia' => 269.94, 
                'alojamiento' => 350.00, 
                'combustible' => 471.08, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 18, 
                'descripcion' => 'Santa Rosa', 
                'distancia' => 81.67, 
                'alojamiento' => 250.00, 
                'combustible' => 142.53, 
                'alimentacion' => 90.00
            ],
            [
                'depto' => 19, 
                'descripcion' => 'Sololá', 
                'distancia' => 146.57, 
                'alojamiento' => 350.00, 
                'combustible' => 255.79, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 20, 
                'descripcion' => 'Suchitepéquez', 
                'distancia' => 149.33, 
                'alojamiento' => 415.00, 
                'combustible' => 260.60, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 21, 
                'descripcion' => 'Totonicapán', 
                'distancia' => 197.11, 
                'alojamiento' => 300.00, 
                'combustible' => 343.99, 
                'alimentacion' => 150.00
            ],
            [
                'depto' => 22, 
                'descripcion' => 'Zacapa', 
                'distancia' => 154.61, 
                'alojamiento' => 300.00, 
                'combustible' => 269.82, 
                'alimentacion' => 90.00
            ],
        ];

        // Usa el método insertBatch() de CodeIgniter para insertar todos los registros de una vez.
        // Asume que la tabla 'departamentos' y sus columnas ya existen.
        return $this->insertBatch($datos); 
    }
}