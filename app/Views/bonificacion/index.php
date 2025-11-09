<?= view('templates/header') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Bonificación por Ventas</h2>

    <!-- Botón Créditos -->
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
    
    <!-- Buscar -->
    <form class="d-flex mb-3" method="get" action="<?= base_url('/bonificacion/buscar'); ?>">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar por ID o nombre...">
        <button class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?= base_url('/bonificacion'); ?>" class="btn btn-secondary ms-2"><i class="bi bi-arrow-clockwise"></i> Limpiar</a>
    </form>

    <!-- Botón nuevo -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalBonificacion">
        <i class="bi bi-plus-circle"></i> Nueva Bonificación
    </button>

    <!-- Tabla -->
    <table id="tablaBonificacion" class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>ID Visitador</th>
                <th>Nombre Visitador</th>
                <th>Ventas Totales (Q)</th>
                <th>Bonificación (Q)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bonificacion as $b): ?>
            <tr>
                <td><?= esc($b['id_visitador']) ?></td>
                <td><?= esc($b['nombre_visitador']) ?></td>
                <td><?= number_format($b['ventas_totales'], 2) ?></td>
                <td><?= number_format($b['bonificacion'], 2) ?></td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalBonificacion"
                            data-id="<?= esc($b['id_visitador']) ?>"
                            data-nombre="<?= esc($b['nombre_visitador']) ?>"
                            data-ventas="<?= esc($b['ventas_totales']) ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <a href="<?= base_url('/bonificacion/delete/' . $b['id_visitador']); ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Está seguro de eliminar esta bonificación?')">
                       <i class="bi bi-trash3"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Botón regresar al menú -->
<div class="text-center mb-3">
    <a href="<?= base_url('/menu'); ?>" class="btn btn-warning">
        <i class="bi bi-arrow-left-circle"></i> Regresar al Menú Principal
    </a>
</div>

<!-- Modal de Crear / Editar -->
<div class="modal fade" id="modalBonificacion" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="formBonificacion">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title"><i class="bi bi-cash-coin"></i> Registrar Bonificación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>ID Visitador</label>
                <input type="text" class="form-control" name="id_visitador" id="id_visitador" required>
            </div>
            <div class="mb-3">
                <label>Nombre Visitador</label>
                <input type="text" class="form-control" name="nombre_visitador" id="nombre_visitador" required>
            </div>
            <div class="mb-3">
                <label>Ventas Totales (Q)</label>
                <input type="number" step="0.01" class="form-control" name="ventas_totales" id="ventas_totales" required>
            </div>
            <p class="text-muted"><small>La bonificación se calculará automáticamente según el total de ventas.</small></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal de Créditos -->
<div class="modal fade" id="modalCreditos" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-person-lines-fill"></i> Créditos del Proyecto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="fw-bold text-center mb-3">Sistema Web de Visitas Médicas - Módulo de Bonificación</p>

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
              <td>202206632</td>
              <td>José Carlos Gálvez Manzo</td>
              <td class="text-start">
                <ul class="mb-0">
                  <li>Diseño de la base de datos <code>bd_visitasmedicas</code></li>
                  <li>CRUD completo de Bonificación (buscar, guardar, editar, eliminar)</li>
                  <li>Integración con DataTables y Bootstrap 5</li>
                  <li>Cálculo automático de bonificación</li>
                  <li>Implementación de rutas, modelos, controladores y vistas</li>
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
