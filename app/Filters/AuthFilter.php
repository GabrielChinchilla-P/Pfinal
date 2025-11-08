<?php 

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Se ejecuta antes de que se acceda al controlador.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si el usuario NO ha iniciado sesión (no existe 'isLoggedIn' en la sesión)
        if (! session()->get('isLoggedIn')) {
            // Guarda el mensaje en la sesión para informar que necesita iniciar sesión
            session()->setFlashdata('msg', 'Debes iniciar sesión para acceder al sistema.');
            
            // Redirige al login. La base_url('/') es tu AuthController::index()
            return redirect()->to(base_url('/'));
        }
    }

    /**
     * Se ejecuta después de que el controlador ha terminado. (No necesitamos nada aquí).
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacer nada
    }
}