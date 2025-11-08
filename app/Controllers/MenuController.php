<?php namespace App\Controllers;

use CodeIgniter\Controller;

class MenuController extends Controller
{
    public function index()
    {
        // 1. Verificar si el usuario está logueado (AuthFilter ya debería hacer esto)
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }

        // 2. Carga la vista con los datos de sesión (¡IMPORTANTE!)
        $data = [
            'nombre'  => session()->get('nombre'),
            // 🚩 PASAMOS LAS VARIABLES NECESARIAS A LA VISTA:
            'usuario' => session()->get('usuario'), // Usado en la cabecera del menú
            'rol'     => session()->get('rol'),     // Usado para la restricción de enlaces
            'title'   => 'Dashboard Principal'
        ];
        
        return view('menu/index', $data); 
    }
}