<?= view('templates/header') ?>

<div class="container mt-4">
  <h2 class="text-center mb-4 text-primary">
    <i class="bi bi-file-earmark-text"></i> Informe de Gastos
  </h2>

  <!-- ✅ ALERTAS -->
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
          <th>ID Gasto</th>
          <th>ID Empleado</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Departamento</th>
          <th>Fecha Visita</th>
          <th>Alimentación (Q)</th>
          <th>Alojamiento (Q)</th>
          <th>Combustible (Q)</th>
          <th>Otros (Q)</th>
          <th>Total Gasto (Q)</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($informes)): ?>
          <?php foreach ($informes as $row): ?>
            <tr>
              <td><?= esc($row['id_gasto']) ?></td>
              <td><?= esc($row['id_empleado']) ?></td>
              <td><?= esc($row['emp_nombre'] ?? '') ?></td>
              <td><?= esc($row['emp_apellido'] ?? '') ?></td>
              <td><?= esc($row['emp_departamento'] ?? '') ?></td>
              <td><?= esc($row['fecha_visita']) ?></td>
              <td><?= esc($row['alimentacion']) ?></td>
              <td><?= esc($row['alojamiento']) ?></td>
              <td><?= esc($row['combustible']) ?></td>
              <td><?= esc($row['otros']) ?></td>
              <td><?= esc($row['total_gasto']) ?></td>
              <td class="text-center">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar<?= $row['id_gasto'] ?>">
                  <i class="bi bi-pencil"></i>
                </button>


                <!-- 💼 MODAL CRÉDITOS -->
<div class="modal fade" id="modalCreditos" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-cash-stack"></i> Créditos - Módulo Informe de Gastos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-4">
          <img src="https://cdn-icons-png.flaticon.com/512/1484/1484584.png" width="85" class="mb-3">
          <h4 class="text-primary">Sistema de Control de Gastos</h4>
          <p class="text-muted">
            Este módulo gestiona los gastos de los empleados durante sus visitas,
            calculando totales con alimentación, alojamiento, combustible y otros costos asociados.
            Desarrollado con <strong>PHP (CodeIgniter 4)</strong>, <strong>Bootstrap 5</strong> y <strong>MySQL</strong>.
          </p>
        </div>

        <h5 class="text-center text-secondary mb-3"><i class="bi bi-person-badge-fill"></i> Equipo de Desarrollo</h5>

        <table class="table table-bordered text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>Carnet</th>
              <th>Nombre</th>
              <th>Procesos Trabajados</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>202206632</td>
              <td>José Carlos Gálvez Manzo</td>
              <td class="text-start">
                <ul class="mb-0">
                  <li>Diseño e implementación CRUD completo.</li>
                  <li>Integración de empleados y departamentos.</li>
                  <li>Validación de datos y alertas flotantes.</li>
                  <li>Diseño visual con modales y DataTables.</li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>

        <hr>

        <div class="row mt-3">
          <div class="col-md-6">
            <p><strong>Proyecto:</strong> Sistema Web de Control de Gastos</p>
            <p><strong>Sección:</strong> Informe de Gastos</p>
            <p><strong>Docente:</strong> Ing. [Nombre del docente]</p>
          </div>
          <div class="col-md-6 text-md-end">
            <p><strong>Curso:</strong> Proyectos de Programación</p>
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
    $('#tablaInformes').DataTable({
      language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });

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