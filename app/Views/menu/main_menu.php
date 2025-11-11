<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container text-center mt-5">
    <h1 class="mb-4">Menú Principal</h1>
    <div class="d-grid gap-3 col-6 mx-auto">
        <a href="<?= base_url('empleados') ?>" class="btn btn-primary btn-lg">Gestión de Empleados</a>
        <a href="<?= base_url('departamentos') ?>" class="btn btn-success btn-lg">Gestión de Departamentos</a>
        <a href="<?= base_url('informegastos') ?>" class="btn btn-warning btn-lg">Informe de Gastos</a>
        <a href="<?= base_url('bonificaciones') ?>" class="btn btn-info btn-lg">Bonificaciones</a>
        <a href="<?= base_url('nomina') ?>" class="btn btn-secondary btn-lg">Nómina</a>
        <a href="<?= base_url('creditos') ?>" class="btn btn-primary btn-lg">Créditos</a>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-danger btn-lg">Salir</a>

    </div>
</div>

</body>
</html>