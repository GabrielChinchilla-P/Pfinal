<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ? $this->renderSection('title') . ' | Gestión RRHH' : 'Gestión de Recursos Humanos'; ?></title>
    <!-- Carga de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /* Aplicar fuente Inter globalmente */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar/Header (Simple) -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="<?= base_url(); ?>" class="text-2xl font-extrabold text-indigo-600">Gestión RRHH</a>
            <!-- Este es el espacio donde podríamos inyectar la navegación superior o lateral más tarde -->
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow py-8">
        <!-- **AQUÍ SE INYECTARÁ EL CONTENIDO DE SUS VISTAS (Bonificación, Empleado, Puesto)** -->
        <?= $this->renderSection('content'); ?>
    </main>

    <!-- Footer (Opcional) -->
    <footer class="bg-gray-800 text-white p-4 text-center mt-auto">
        &copy; <?= date('Y'); ?> Sistema de Gestión de Recursos Humanos.
    </footer>

</body>
</html>