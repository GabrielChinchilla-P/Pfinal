<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Creditos extends Controller
{
    public function index()
    {
        return view('creditos/creditos', ['title' => 'Créditos']);
    }
}