<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-file-invoice-dollar"></i> <?= esc($title); ?></h1>
        <a href="<?= base_url('informegasto/create'); ?>" class="btn btn-warning btn-sm">
            <i class="fa-solid fa-plus"></i> Registrar Nuevo Gasto
        </a>
    </div>
    <div class="card-body">
        
        <!-- Formulario de Búsqueda -->
        <form action="<?= base_url('informegasto'); ?>" method="get" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar por empleado, departamento o fecha..." 
                       value="<?= esc($searchQuery); ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
                    <?php if ($searchQuery): ?>
                        <a href="<?= base_url('informegasto'); ?>" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <h2 class="h5 mb-3">Informes Registrados</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Departamento</th>
                        <th>Fecha Visita</th>
                        <th>Alimentación</th>
                        <th>Alojamiento</th>
                        <th>Combustible</th>
                        <th>Otros</th>
                        <th>TOTAL GASTO</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($informes)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                <?php if ($searchQuery): ?>
                                    No se encontraron resultados para la búsqueda: **<?= esc($searchQuery); ?>**.
                                <?php else: ?>
                                    No hay informes de gasto registrados.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($informes as $informe): ?>
                        <tr>
                            <td><?= esc($informe['id_gasto']); ?></td>
                            <td><?= esc($informe['nombre_empleado']) . ' ' . esc($informe['apellido_empleado']); ?></td>
                            <td><?= esc($informe['nombre_departamento']); ?></td>
                            <td><?= date('d/m/Y', strtotime(esc($informe['fecha_visita']))); ?></td>
                            <td>$<?= number_format($informe['alimentacion'], 2); ?></td>
                            <td>$<?= number_format($informe['alojamiento'], 2); ?></td>
                            <td>$<?= number_format($informe['combustible'], 2); ?></td>
                            <td>$<?= number_format($informe['otros'], 2); ?></td>
                            <td><strong>$<?= number_format($informe['total_gasto'], 2); ?></strong></td>
                            <td>
                                <!-- Botón Editar -->
                                <a href="<?= base_url('informegasto/edit/' . $informe['id_gasto']); ?>" class="btn btn-sm btn-warning" title="Editar"><i class="fa-solid fa-pencil"></i></a>
                                
                                <!-- Botón Eliminar (usando SweetAlert para confirmación) -->
                                <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                        data-id="<?= esc($informe['id_gasto']); ?>" 
                                        data-nombre="<?= esc($informe['nombre_empleado']) . ' de ' . esc($informe['nombre_departamento']); ?>"
                                        title="Eliminar">
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
                const deleteUrl = '<?= base_url('informegasto/delete'); ?>/' + id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `Vas a eliminar el informe de gastos de **${nombre}**. ¡Esta acción es irreversible!`,
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