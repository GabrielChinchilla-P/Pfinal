<?= view('templates/header') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Gestión de Departamentos</h2>

    <!-- 🔙 Botón regresar al menú -->
    <div class="text-center mb-3">
        <a href="<?= base_url('/menu'); ?>" class="btn btn-warning">
            <i class="bi bi-arrow-left-circle"></i> Regresar al Menú Principal
        </a>
    </div>

    <!-- 🪪 Botón créditos -->
    <div class="text-center mb-4">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreditos">
            <i class="bi bi-people-fill"></i> Ver Créditos del Equipo
        </button>
    </div>

    <!-- Alertas -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Barra de búsqueda -->
    <form class="d-flex mb-3" method="get" action="<?= base_url('/departamentos/buscar'); ?>">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar por código o descripción...">
        <button class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?= base_url('/departamentos'); ?>" class="btn btn-secondary ms-2"><i
                class="bi bi-arrow-clockwise"></i> Limpiar</a>
    </form>

    <!-- Botón nuevo -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalDepartamento">
        <i class="bi bi-plus-circle"></i> Nuevo Departamento
    </button>

    <!-- Tabla -->
    <table id="tablaDepartamentos" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Código</th>
                <th>Descripción</th>
                <th>Distancia (km)</th>
                <th>Alojamiento (Q)</th>
                <th>Combustible (Q)</th>
                <th>Alimentación (Q)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departamentos as $d): ?>
            <tr class="text-center">
                <td><?= esc($d['depto']) ?></td>
                <td><?= esc($d['descripcion']) ?></td>
                <td><?= esc($d['distancia']) ?></td>
                <td><?= esc($d['alojamiento']) ?></td>
                <td><?= esc($d['combustible']) ?></td>
                <td><?= esc($d['alimentacion']) ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDepartamento"
                        data-id="<?= esc($d['depto']) ?>" data-descripcion="<?= esc($d['descripcion']) ?>"
                        data-distancia="<?= esc($d['distancia']) ?>" data-alojamiento="<?= esc($d['alojamiento']) ?>"
                        data-combustible="<?= esc($d['combustible']) ?>"
                        data-alimentacion="<?= esc($d['alimentacion']) ?>">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <a href="<?= base_url('/departamentos/delete/' . $d['depto']); ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Seguro que desea eliminar este departamento?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Modal CRUD -->
<div class="modal fade" id="modalDepartamento" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="formDepartamento">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="bi bi-building"></i> Departamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Código</label>
                        <input type="text" class="form-control" name="depto" id="depto" required>
                    </div>
                    <div class="mb-3">
                        <label>Descripción</label>
                        <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label>Distancia (km)</label>
                        <input type="number" step="0.01" class="form-control" name="distancia" id="distancia" required>
                    </div>
                    <div class="mb-3">
                        <label>Alojamiento (Q)</label>
                        <input type="number" step="0.01" class="form-control" name="alojamiento" id="alojamiento"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Alimentación (Q)</label>
                        <input type="number" step="0.01" class="form-control" name="alimentacion" id="alimentacion"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 🪪 Modal de Créditos -->
<div class="modal fade" id="modalCreditos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-lines-fill"></i> Créditos del Proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="fw-bold text-center mb-3">Sistema Web de Visitas Médicas - Módulo de Departamentos</p>

                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Carnet</th>
                            <th>Nombre</th>
                            <th>Procesos trabajados</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td>202108186</td>
                            <td>Carmen Zet Siney</td>
                            <td class="text-start">
                                <ul class="mb-0">
                                    <li>Desarrollo del CRUD de Departamentos (buscar, guardar, editar, eliminar)</li>
                                    <li>Diseño e integración con Bootstrap 5 y DataTables</li>
                                    <li>Cálculo automático de gastos de combustible</li>
                                    <li>Implementación de modales y alertas dinámicas</li>
                                </ul>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Script -->
<script>
  const modal = document.getElementById('modalDepartamento');
  modal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const form = document.getElementById('formDepartamento');

    if (id) {
        form.action = '<?= base_url('/departamentos/update/'); ?>' + id;
        document.getElementById('depto').value = button.getAttribute('data-id');
        document.getElementById('descripcion').value = button.getAttribute('data-descripcion');
        document.getElementById('distancia').value = button.getAttribute('data-distancia');
        document.getElementById('alojamiento').value = button.getAttribute('data-alojamiento');
        document.getElementById('alimentacion').value = button.getAttribute('data-alimentacion');
        document.getElementById('depto').readOnly = true;
    } else {
        form.action = '<?= base_url('/departamentos/store'); ?>';
        form.reset();
        document.getElementById('depto').readOnly = false;
    }
  });

  // DataTable
 new DataTable('#tablaDepartamentos');
</script>
<?= view('templates/footer') ?>