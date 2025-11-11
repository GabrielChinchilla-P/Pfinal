<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Creditos extends Controller
{
    public function index()
    {
        // Muestra la vista de créditos
        return view('layouts/header')
            . view('creditos/creditos');
    }
}