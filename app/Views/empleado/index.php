<div class="container mt-4">
    <h2 class="text-center mb-4">Gestión de Empleados</h2>

    <!-- Alertas -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Búsqueda -->
    <form class="d-flex mb-3" method="get" action="<?= base_url('/empleados/buscar'); ?>">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar empleado...">
        <button class="btn btn-primary">Buscar</button>
        <a href="<?= base_url('/empleados'); ?>" class="btn btn-secondary ms-2">Limpiar</a>
    </form>

    <!-- Botón nuevo -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalEmpleado">
        <i class="bi bi-plus-circle"></i> Nuevo Empleado
    </button>

    <!-- Tabla -->
    <table id="tablaEmpleados" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Departamento</th>
                <th>Fecha Ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($empleados as $e): ?>
            <tr>
                <td><?= $e['cod_empleado'] ?></td>
                <td><?= $e['nombre'] ?></td>
                <td><?= $e['apellido'] ?></td>
                <td><?= $e['departamento'] ?></td>
                <td><?= $e['fecha_ingreso'] ?></td>
                <td>
                    <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEmpleado"
                            data-id="<?= $e['cod_empleado'] ?>"
                            data-nombre="<?= $e['nombre'] ?>"
                            data-apellido="<?= $e['apellido'] ?>"
                            data-departamento="<?= $e['departamento'] ?>"
                            data-fecha="<?= $e['fecha_ingreso'] ?>">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <a href="<?= base_url('/empleados/delete/' . $e['cod_empleado']); ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Seguro que desea eliminar este empleado?')">
                       <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEmpleado" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formEmpleado">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title">Empleado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Código</label>
                <input type="text" class="form-control" name="cod_empleado" id="cod_empleado" required>
            </div>
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="mb-3">
                <label>Apellido</label>
                <input type="text" class="form-control" name="apellido" id="apellido" required>
            </div>
            <div class="mb-3">
                <label>Departamento</label>
                <input type="text" class="form-control" name="departamento" id="departamento" required>
            </div>
            <div class="mb-3">
                <label>Fecha Ingreso</label>
                <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
                        <td>202112444</td>
                        <td>Katherine Nicole Villavicencio Cabrera</td>
                        <td class="text-start">
                            <ul class="mb-0">
                                <li>Desarrollo del CRUD de Empleados (buscar, guardar, editar, eliminar)</li>
                                <li>Diseño e integración con Bootstrap 5 y DataTables</li>
                                <li>Implementación de modales y alertas dinámicas</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
</table>

<script>
    const modalEmp = document.getElementById('modalEmpleado');
    modalEmp.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const form = document.getElementById('formEmpleado');

        if (id) {
            form.action = '<?= base_url('/empleados/update/'); ?>' + id;
            document.getElementById('cod_empleado').value = id;
            document.getElementById('nombre').value = button.getAttribute('data-nombre');
            document.getElementById('apellido').value = button.getAttribute('data-apellido');
            document.getElementById('departamento').value = button.getAttribute('data-departamento');
            document.getElementById('fecha_ingreso').value = button.getAttribute('data-fecha');
            document.getElementById('cod_empleado').readOnly = true;
        } else {
            form.action = '<?= base_url('/empleados/store'); ?>';
            form.reset();
            document.getElementById('cod_empleado').readOnly = false;
        }
    });

    new DataTable('#tablaEmpleados');
</script>
