<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-building"></i> <?= esc($title); ?></h1>
        <a href="<?= base_url('departamento/create'); ?>" class="btn btn-warning btn-sm">
            <i class="fa-solid fa-plus"></i> Crear Nuevo Departamento
        </a>
    </div>
    <div class="card-body">
        
        <!-- Formulario de Búsqueda -->
        <form action="<?= base_url('departamento'); ?>" method="get" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar por nombre o distancia..." 
                       value="<?= esc($searchQuery); ?>">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit"><i class="fa-solid fa-search"></i> Buscar</button>
                    <?php if ($searchQuery): ?>
                        <a href="<?= base_url('departamento'); ?>" class="btn btn-outline-secondary">Limpiar</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <h2 class="h5 mb-3">Listado de Departamentos</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Departamento</th>
                        <th>Distancia (Km)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($departamentos)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <?php if ($searchQuery): ?>
                                    No se encontraron resultados para la búsqueda: **<?= esc($searchQuery); ?>**.
                                <?php else: ?>
                                    No hay departamentos registrados.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($departamentos as $depto): ?>
                        <tr>
                            <td><?= esc($depto['id_departamento']); ?></td>
                            <td><?= esc($depto['nombre_departamento']); ?></td>
                            <td><?= number_format($depto['distancia_km'], 2); ?></td>
                            <td>
                                <!-- Botón Editar -->
                                <a href="<?= base_url('departamento/edit/' . $depto['id_departamento']); ?>" class="btn btn-sm btn-warning" title="Editar"><i class="fa-solid fa-pencil"></i></a>
                                
                                <!-- Botón Eliminar (usando SweetAlert para confirmación) -->
                                <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                        data-id="<?= esc($depto['id_departamento']); ?>" 
                                        data-nombre="<?= esc($depto['nombre_departamento']); ?>"
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
                const deleteUrl = '<?= base_url('departamento/delete'); ?>/' + id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: `Vas a eliminar el departamento **${nombre}**. ¡Esta acción es irreversible!`,
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