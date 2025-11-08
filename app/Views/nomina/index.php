<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-money-bill-wave"></i> <?= esc($title); ?></h1>
        
        <!-- BOTÓN PARA AGREGAR NUEVO REGISTRO -->
        <a href="<?= base_url('nomina/create'); ?>" class="btn btn-warning btn-sm">
            <i class="fa-solid fa-plus"></i> Calcular Nueva Nómina
        </a>
    </div>
    <div class="card-body">
        
        <!-- Formulario de Búsqueda -->
        <form action="<?= base_url('nomina'); ?>" method="get" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar por mes, nombre o usuario del empleado..." 
                       value="<?= esc($searchQuery); ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
                    <?php if ($searchQuery): ?>
                        <a href="<?= base_url('nomina'); ?>" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <h2 class="h5 mb-3">Registros de Pagos</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Nómina</th>
                        <th>Empleado</th>
                        <th>Mes</th>
                        <th>Sueldo Base</th>
                        <th>Bonificación</th>
                        <th>IGSS</th>
                        <th>Descuentos</th>
                        <th>Sueldo Líquido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($nominas)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                <?php if ($searchQuery): ?>
                                    No se encontraron resultados para la búsqueda: **<?= esc($searchQuery); ?>**.
                                <?php else: ?>
                                    No hay registros de nómina para mostrar.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($nominas as $nomina): ?>
                        <tr>
                            <td><?= esc($nomina['id_nomina']); ?></td>
                            <td><?= esc($nomina['nombre_empleado']); ?> (<?= esc($nomina['nombre_usuario']); ?>)</td>
                            <td><?= esc($nomina['mes']); ?></td>
                            <td>$<?= number_format($nomina['sueldo_base'], 2); ?></td>
                            <td>$<?= number_format($nomina['bonificacion'], 2); ?></td>
                            <td>$<?= number_format($nomina['IGSS'], 2); ?></td>
                            <td>$<?= number_format($nomina['descuentos'], 2); ?></td>
                            <td>**$<?= number_format($nomina['sueldo_liquido'], 2); ?>**</td>
                            <td>
                                <!-- Botón EDITAR: Llama a Nomina::edit/ID -->
                                <a href="<?= base_url('nomina/edit/' . $nomina['id_nomina']); ?>" class="btn btn-sm btn-warning" title="Editar Nómina">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                
                                <!-- Botón ELIMINAR: Dispara la función JavaScript (SweetAlert) -->
                                <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                        data-id="<?= esc($nomina['id_nomina']); ?>" 
                                        data-nombre="<?= esc($nomina['nombre_empleado']); ?>"
                                        title="Eliminar Nómina">
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
                const deleteUrl = '<?= base_url('nomina/delete'); ?>/' + id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `Estás a punto de eliminar la nómina de **${nombre}**. ¡Esta acción es irreversible!`,
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