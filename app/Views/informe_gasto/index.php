<?= view('templates/header') ?>

<div class="container mt-4">
  <h2 class="text-center mb-4 text-primary">
    <i class="bi bi-file-earmark-text"></i> Informe de Gastos
  </h2>

  <!-- ✅ BOTONES SUPERIORES -->
  <div class="d-flex justify-content-between mb-3">
    <div>
      <a href="<?= base_url('/menu'); ?>" class="btn btn-secondary me-2">
        <i class="bi bi-house-door"></i> Regresar al Menú
      </a>
      <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalCreditos">
  <i class="bi bi-people-fill"></i> Créditos
</button>
    </div>
    <div class="d-flex">
      <form method="post" action="<?= site_url('informe_gastos/buscar') ?>" class="d-flex me-2">
        <input type="text" name="id_informe" class="form-control me-2" placeholder="Buscar por ID">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
      </form>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        <i class="bi bi-plus-circle"></i> Nuevo Informe
      </button>
    </div>
  </div>

  <!-- ✅ ALERTAS FLOTANTES -->
  <?php if (session()->getFlashdata('success')): ?>
    <div id="alerta" class="alert alert-success alert-dismissible fade show text-center position-fixed top-0 start-50 translate-middle-x shadow" style="z-index:1055; width:60%; margin-top:10px;">
      <strong><i class="bi bi-check-circle"></i></strong> <?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php elseif (session()->getFlashdata('error')): ?>
    <div id="alerta" class="alert alert-danger alert-dismissible fade show text-center position-fixed top-0 start-50 translate-middle-x shadow" style="z-index:1055; width:60%; margin-top:10px;">
      <strong><i class="bi bi-x-circle"></i></strong> <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- 🧾 TABLA PRINCIPAL -->
  <div class="table-responsive">
    <table id="tablaInformes" class="table table-bordered table-striped align-middle">
      <thead class="table-primary text-center">
        <tr>
          <th>ID</th>
          <th>Cód. Empleado</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Departamento</th>
          <th>Fecha Inicio</th>
          <th>Fecha Fin</th>
          <th>Fecha Visita</th>
          <th>Cód. Depto</th>
          <th>Descripción</th>
          <th>Otros (Q)</th>
          <th>Total (Q)</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($informes)): ?>
          <?php foreach ($informes as $row): ?>
            <tr>
              <td><?= esc($row['id_informe']) ?></td>
              <td><?= esc($row['cod_empleado']) ?></td>
              <td><?= esc($row['nombre'] ?? '') ?></td>
              <td><?= esc($row['apellido'] ?? '') ?></td>
              <td><?= esc($row['departamento'] ?? '') ?></td>
              <td><?= esc($row['fecha_inicio']) ?></td>
              <td><?= esc($row['fecha_fin']) ?></td>
              <td><?= esc($row['fecha_visita']) ?></td>
              <td><?= esc($row['cod_depto']) ?></td>
              <td><?= esc($row['descripcion']) ?></td>
              <td><?= esc($row['otros']) ?></td>
              <td><?= esc($row['total']) ?></td>
              <td class="text-center">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $row['id_informe'] ?>">
                  <i class="bi bi-pencil"></i>
                </button>
                
                

<!-- 💼 MODAL CRÉDITOS - ENFOCADO EN INFORME DE GASTOS -->
<div class="modal fade" id="modalCreditos" tabindex="-1" aria-labelledby="modalCreditosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalCreditosLabel">
          <i class="bi bi-cash-stack"></i> Créditos - Módulo Informe de Gastos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">
        <div class="text-center mb-4">
          <img src="https://cdn-icons-png.flaticon.com/512/1484/1484584.png" width="85" class="mb-3">
          <h4 class="text-primary">Sistema de Control de Informe de Gastos</h4>
          <p class="text-muted">
            Este módulo permite registrar, controlar y visualizar los informes de gastos realizados por los visitadores médicos.
            Incluye registro de fechas, descripción de visitas, totales de gasto, y relación con empleados y departamentos.
            Desarrollado con <strong>PHP (CodeIgniter 4)</strong>, <strong>Bootstrap 5</strong> y <strong>MySQL</strong>.
          </p>
        </div>

        <h5 class="text-center text-secondary mb-3">
          <i class="bi bi-person-badge-fill"></i> Equipo de Desarrollo
        </h5>

        <table class="table table-bordered text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>Carnet</th>
              <th>Nombre</th>
              <th>Responsabilidades en el Módulo</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>202206632</td>
              <td>José Carlos Gálvez Manzo</td>
              <td class="text-start">
                <ul class="mb-0">
                  <li>Diseño e implementación del CRUD completo de informes.</li>
                  <li>Integración de empleados y departamentos con autorrelleno.</li>
                  <li>Validaciones, mensajes dinámicos y alertas flotantes.</li>
                  <li>Desarrollo de interfaz con modales y DataTables.</li>
                  <li>Optimización visual con Bootstrap y JavaScript.</li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>

        <hr>

        <div class="row mt-3">
          <div class="col-md-6">
            <p><strong>Proyecto:</strong> Sistema Web de Visitas Médicas</p>
            <p><strong>Sección:</strong> Informe de Gastos</p>
            <p><strong>Docente:</strong> Ing. [Nombre del docente]</p>
          </div>
          <div class="col-md-6 text-md-end">
            <p><strong>Curso:</strong> prollectos de Programación</p>
            <p><strong>Versión:</strong> 1.0</p>
            <p><strong>Fecha:</strong> Noviembre 2025</p>
          </div>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <a href="<?= base_url('/menu'); ?>" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle"></i> Regresar al Menú
        </a>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle"></i> Cerrar
        </button>
      </div>

    </div>
  </div>
</div>

<!-- ⚙️ SCRIPTS -->
<script>
  $(document).ready(function() {
    // Inicializar DataTable
    $('#tablaInformes').DataTable({
      language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });

    // Confirmar eliminación
    $('.btn-eliminar').on('click', function(e) {
      if (!confirm('¿Seguro que desea eliminar este informe?')) e.preventDefault();
    });

    // Ocultar alerta automáticamente
    setTimeout(() => {
      const alerta = document.getElementById('alerta');
      if (alerta) {
        alerta.classList.remove('show');
        alerta.classList.add('fade');
        setTimeout(() => alerta.remove(), 1000);
      }
    }, 4000);
  });
</script>

<?= view('templates/footer') ?>