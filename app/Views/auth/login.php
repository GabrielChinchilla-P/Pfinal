<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register - VM</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/estilos.css'); ?>">
</head>
<body>

<main>
    <div class="contenedor__todo">
        
        <div class="caja__mensajes">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('msg')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> <?= session()->getFlashdata('msg') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-warning">
                    <p>Hubo errores de validación:</p>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="caja__trasera">
            <div class="caja__trasera-login">
                <h3>¿Ya tienes una cuenta?</h3>
                <p>Inicia sesión para entrar en la página</p>
                <button id="btn__iniciar-sesion">Iniciar Sesión</button>
            </div>
            <div class="caja__trasera-register">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Regístrate para que puedas iniciar sesión</p>
                <button id="btn__registrarse">Regístrarse</button>
            </div>
        </div>

        <div class="contenedor__login-register">

            <form action="<?= base_url('auth/login'); ?>" method="post" class="formulario__login">
                <h2>Iniciar Sesión</h2>
                <input type="text" name="email_login" placeholder="Correo Electrónico" required>
                <input type="password" name="password_login" placeholder="Contraseña" required>
                <button type="submit">Entrar</button>
            </form>

            <form action="<?= base_url('auth/register'); ?>" method="post" class="formulario__register">
                <h2>Regístrarse</h2>
                <input type="text" name="nombre_completo" placeholder="Nombre completo" required>
                <input type="email" name="email_register" placeholder="Correo Electrónico" required>
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="password_register" placeholder="Contraseña" required>
                
                <select name="rol" class="form-control" style="margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="empleado">Empleado</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="rrhh">RRHH</option>
                    <option value="admin">Administrador</option>
                </select>
                
                <button type="submit">Registrar</button>
            </form>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/script.js'); ?>"></script>
</body>
</html>