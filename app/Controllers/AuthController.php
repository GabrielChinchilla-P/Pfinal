<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    /**
     * Muestra la vista de Login/Registro (la raíz del sitio).
     */
    public function index()
    {
        // Si el usuario ya está logueado, no tiene sentido mostrar el login.
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('menu'));
        }
        
        // Carga la vista de login.php
        return view('auth/login');
    }

    /**
     * Procesa el formulario de LOGIN.
     */
    public function login()
    {
        $session = session();
        $model = new UserModel();

        // 1. Reglas de Validación
        $rules = [
            'email_login'    => 'required|min_length[6]|max_length[100]|valid_email',
            'password_login' => 'required|min_length[8]',
        ];

        // 2. Verificar Validación
        if ($this->validate($rules)) {
            $email = $this->request->getPost('email_login');
            $password = $this->request->getPost('password_login');

            // 3. Buscar el usuario por correo
            $user = $model->where('correo', $email)->first();

            if ($user) {
                // 4. Verificar la contraseña
                if (password_verify($password, $user['contrasena'])) {
                    
                    // 5. Crear la Sesión (Datos a guardar en el navegador)
                    $ses_data = [
                        'id'           => $user['id_usuario'],
                        'nombre'       => $user['nombre'],
                        'usuario'      => $user['usuario'], // Agregado para el menú
                        'rol'          => $user['rol'],
                        'isLoggedIn'   => TRUE,
                    ];
                    $session->set($ses_data);
                    
                    // 6. Éxito: Enviar mensaje de bienvenida (para SweetAlert) y redirigir
                    $session->setFlashdata('bienvenida', 'true');
                    return redirect()->to(base_url('menu'));

                } else {
                    // Contraseña incorrecta
                    $session->setFlashdata('msg', 'Contraseña incorrecta.');
                    return redirect()->to(base_url('/'))->withInput();
                }
            } else {
                // Usuario no encontrado
                $session->setFlashdata('msg', 'El correo no está registrado.');
                return redirect()->to(base_url('/'))->withInput();
            }

        } else {
            // Fallo en la validación de campos de login
            $session->setFlashdata('msg', 'Verifica los campos de correo y contraseña.');
            $session->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('/'))->withInput();
        }
    }

    /**
     * Procesa el formulario de REGISTRO.
     */ 
    public function register()
    {
        $session = session();
        $model = new UserModel();

        // 1. Reglas de Validación de CI4
        $rules = [
            'nombre_completo'   => 'required|min_length[3]|max_length[100]',
            // Verifica que el correo sea único en la columna 'correo' de la tabla 'usuarios'
            'email_register'    => 'required|min_length[6]|max_length[100]|valid_email|is_unique[usuarios.correo]', 
            'usuario'           => 'required|min_length[3]|max_length[50]|is_unique[usuarios.usuario]',
            'password_register' => 'required|min_length[8]',
            'rol'               => 'required|in_list[admin,rrhh,supervisor,empleado]'
        ];

        if ($this->validate($rules)) {
            
            // 2. Datos listos para la base de datos (Mapeados a los nombres de la DB)
            $data = [
                'nombre'     => $this->request->getPost('nombre_completo'),
                'correo'     => $this->request->getPost('email_register'),
                'usuario'    => $this->request->getPost('usuario'),
                // ¡IMPORTANTE! HASH de la contraseña antes de guardar
                'contrasena' => password_hash($this->request->getPost('password_register'), PASSWORD_DEFAULT),
                'rol'        => $this->request->getPost('rol'),
            ];

            // 3. Guardar el nuevo usuario
            $model->save($data);

            // 4. Éxito: Redirigir al login
            $session->setFlashdata('success', '¡Registro exitoso! Ya puedes iniciar sesión.');
            return redirect()->to(base_url('/')); 

        } else {
            // 5. Fallo: Regresar al formulario con errores
            $session->setFlashdata('msg', 'Error en el registro. Revisa los campos.');
            $session->setFlashdata('errors', $this->validator->getErrors());
            // withInput() mantiene los datos del formulario (excepto la contraseña)
            return redirect()->to(base_url('/'))->withInput(); 
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
}