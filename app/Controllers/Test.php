<?php

namespace App\Controllers;
use App\Models\InformeGastoModel;

class Test extends BaseController
{
    public function index()
    {
        $model = new InformeGastoModel();
        echo "Modelo cargado correctamente";
    }
}