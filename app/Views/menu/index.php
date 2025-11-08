<?= $this->include('layouts/header'); ?>

<?php if (session()->getFlashdata('bienvenida')): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      Swal.fire({
        // Usamos session('nombre') si ya la tenemos cargada, o la variable $nombre si la pasamos
        title: '¡Bienvenido <?= esc(session('nombre') ?? 'Usuario'); ?>!',
        text: 'Has iniciado sesión correctamente en el sistema Visitas Médicas.',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Continuar'
      });
    });
    </script>
<?php endif; ?>

<div class="container mt-5">
    <div class="text-center mb-4">
        <h2>Bienvenido al Sistema de Visitas Médicas</h2>
        <p>
            Usuario: <strong><?= esc($usuario) ?></strong> |
            Rol: <span class="badge bg-info text-dark"><?= esc($rol) ?></span>
        </p>
    </div>

    <div class="row justify-content-center g-4">

        <?php if (in_array($rol, ['admin', 'rrhh', 'supervisor'])): ?>
        <div class="col-md-4">
            <a href="<?= base_url('empleado'); ?>" class="btn btn-outline-primary w-100 p-4 shadow-sm rounded-3">
                👨‍💼 <br> <strong>Gestión de Empleados</strong>
            </a>
        </div>
        <?php endif; ?>

        <?php if (in_array($rol, ['admin', 'rrhh', 'supervisor'])): ?>
        <div class="col-md-4">
            <a href="<?= base_url('departamento'); ?>" class="btn btn-outline-success w-100 p-4 shadow-sm rounded-3">
                🏢 <br> <strong>Gestión de Departamentos</strong>
            </a>
        </div>
        <?php endif; ?>

        <?php if (in_array($rol, ['admin', 'rrhh'])): ?>
        <div class="col-md-4">
            <a href="<?= base_url('informegasto'); ?>" class="btn btn-outline-warning w-100 p-4 shadow-sm rounded-3">
                💰 <br> <strong>Informe de Gastos</strong>
            </a>
        </div>
        <?php endif; ?>

        <?php if (in_array($rol, ['admin', 'rrhh'])): ?>
        <div class="col-md-4">
            <a href="<?= base_url('bonificacion'); ?>" class="btn btn-outline-info w-100 p-4 shadow-sm rounded-3">
                🎁 <br> <strong>Bonificaciones</strong>
            </a>
        </div>
        <?php endif; ?>

        <?php if ($rol === 'admin'): ?>
        <div class="col-md-4">
            <a href="<?= base_url('nomina'); ?>" class="btn btn-outline-secondary w-100 p-4 shadow-sm rounded-3">
                📋 <br> <strong>Nómina</strong>
            </a>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
            <a href="<?= base_url('logout'); ?>" class="btn btn-outline-danger w-100 p-4 shadow-sm rounded-3">
                🚪 <br> <strong>Salir del Sistema</strong>
            </a>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>