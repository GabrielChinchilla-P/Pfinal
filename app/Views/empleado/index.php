<div class="container mt-4">
    <h2 class="text-center mb-4">Gestión de Empleados</h2>

    <!-- Alertas -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>








<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-success text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-users"></i> <?= esc($title); ?></h1>
        
        <!-- BOTÓN PARA AGREGAR NUEVO REGISTRO -->
        <a href="<?= base_url('empleado/create'); ?>" class="btn btn-warning btn-sm">
            <i class="fa-solid fa-plus"></i> Nuevo Empleado
        </a>
    </div>
    <div class="card-body">
        
        <!-- Formulario de Búsqueda -->
        <form action="<?= base_url('empleado'); ?>" method="get" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar por nombre, apellido o DPI..." 
                       value="<?= esc($searchQuery); ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
                    <?php if ($searchQuery): ?>
                        <a href="<?= base_url('empleado'); ?>" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <h2 class="h5 mb-3">Lista de Personal</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>DPI</th>
                        <th>Puesto</th>
                        <th>Sueldo Base</th>
                        <th>Usuario Asignado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($empleados)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No hay empleados registrados o no se encontraron resultados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?= esc($empleado['id_empleado']); ?></td>
                            <td><?= esc($empleado['nombre']) . ' ' . esc($empleado['apellido']); ?></td>
                            <td><?= esc($empleado['dpi']); ?></td>
                            <td><?= esc($empleado['puesto']); ?></td>
                            <td>$<?= number_format($empleado['sueldo_base'], 2); ?></td>
                            <td><?= esc($empleado['nombre_usuario']); ?></td>
                            <td>
                                <!-- Botón EDITAR: Llama a Empleado::edit/ID -->
                                <a href="<?= base_url('empleado/edit/' . $empleado['id_empleado']); ?>" class="btn btn-sm btn-warning" title="Editar Empleado">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                
                                <!-- Botón ELIMINAR: Dispara la función JavaScript (SweetAlert) -->
                                <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                        data-id="<?= esc($empleado['id_empleado']); ?>" 
                                        data-nombre="<?= esc($empleado['nombre']) . ' ' . esc($empleado['apellido']); ?>"
                                        title="Eliminar Empleado">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

<!-- SCRIPTS PARA SWEETALERT DE CONFIRMACIÓN DE ELIMINACIÓN -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const deleteUrl = '<?= base_url('empleado/delete'); ?>/' + id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `Vas a eliminar el registro de **${nombre}**. Esto puede afectar la Nómina. ¡Esta acción es irreversible!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, ¡Eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si confirma, redirige al método delete del controlador
                        window.location.href = deleteUrl;
                    }
                });
            });
        });
    });
</script>

<?= $this->include('layouts/footer'); ?>