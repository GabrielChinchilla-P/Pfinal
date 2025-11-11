<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Informe | Sistema Visitas Médicas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        header.navbar { background-color: #007bff; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        header .navbar-brand { font-weight: 600; color: #fff !important; font-size: 1.3rem; }
        header .nav-link { color: #fff !important; margin-right: 10px; transition: all 0.3s ease; }
        header .nav-link:hover { text-decoration: underline; color: #dfe6e9 !important; }
        footer { background: #007bff; color: white; text-align: center; padding: 15px; margin-top: 30px; }
    </style>
</head>

<body>

<main class="container py-4">

<?php if (session()->getFlashdata('msg')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Editar Informe de Gastos</h3>
    </div>
    <div class="card-body">

        <form action="<?= site_url('informegasto/update/' . ($informe['id_informe'] ?? '')) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <!-- EMPLEADO Y DEPARTAMENTO -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="cod_empleado" class="form-label">Empleado</label>
                    <select name="cod_empleado" id="cod_empleado" class="form-select" required>
                        <option value="">-- Seleccione empleado --</option>
                        <?php foreach($empleados as $e): ?>
                        <option value="<?= esc($e['cod_empleado']) ?>"
                            data-nombre="<?= esc($e['nombre']) ?>"
                            data-apellido="<?= esc($e['apellido']) ?>"
                            <?= ($informe['cod_empleado'] ?? '') == $e['cod_empleado'] ? 'selected' : '' ?>>
                            <?= esc($e['nombre'].' '.$e['apellido']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="cod_depto" class="form-label">Departamento</label>
                    <select name="cod_depto" id="cod_depto" class="form-select" required>
                        <option value="">-- Seleccione departamento --</option>
                        <?php foreach($departamentos as $d): ?>
                        <option value="<?= esc($d['depto']) ?>"
                            data-descripcion="<?= esc($d['descripcion']) ?>"
                            <?= ($informe['cod_depto'] ?? '') == $d['depto'] ? 'selected' : '' ?>>
                            <?= esc($d['descripcion']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- FECHA Y GASTOS -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="fecha_visita" class="form-label">Fecha Visita</label>
                    <input type="date" name="fecha_visita" class="form-control" value="<?= esc($informe['fecha_visita'] ?? '') ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="otros" class="form-label">Otros Gastos</label>
                    <input type="number" name="otros" class="form-control" step="0.01" value="<?= esc($informe['otros'] ?? 0) ?>" required>
                </div>
            </div>

            <!-- COSTOS FIJOS -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="alimentacion" class="form-label">Alimentación</label>
                    <input type="number" name="alimentacion" id="alimentacion" class="form-control" step="0.01"
                        value="<?= esc($informe['alimentacion'] ?? 0) ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label for="alojamiento" class="form-label">Alojamiento</label>
                    <input type="number" name="alojamiento" id="alojamiento" class="form-control" step="0.01"
                        value="<?= esc($informe['alojamiento'] ?? 0) ?>" readonly>
                </div>
                <div class="col-md-4">
                    <label for="combustible" class="form-label">Combustible</label>
                    <input type="number" name="combustible" id="combustible" class="form-control" step="0.01"
                        value="<?= esc($informe['combustible'] ?? 0) ?>" readonly>
                </div>
            </div>

            <!-- DESCRIPCIÓN -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción de la Visita</label>
                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"><?= esc($informe['descripcion'] ?? '') ?></textarea>
            </div>

            <!-- BOTONES -->
            <div class="text-end">
                <a href="<?= site_url('informegasto') ?>" class="btn btn-secondary me-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cambios
                </button>
            </div>

            <!-- CAMPOS OCULTOS -->
            <input type="hidden" name="nombre" id="nombre_empleado_hidden">
            <input type="hidden" name="apellido" id="apellido_empleado_hidden">
            <input type="hidden" name="departamento" id="nombre_departamento_hidden">
        </form>
    </div>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectEmpleado = document.getElementById('cod_empleado');
    const selectDepartamento = document.getElementById('cod_depto');

    const nombreInput = document.getElementById('nombre_empleado_hidden');
    const apellidoInput = document.getElementById('apellido_empleado_hidden');
    const departamentoInput = document.getElementById('nombre_departamento_hidden');

    const inputAlimentacion = document.getElementById('alimentacion');
    const inputAlojamiento = document.getElementById('alojamiento');
    const inputCombustible = document.getElementById('combustible');

    // Actualiza los campos ocultos al cambiar empleado o depto
    function updateHiddenFields() {
        const selectedEmpleado = selectEmpleado.options[selectEmpleado.selectedIndex];
        nombreInput.value = selectedEmpleado?.getAttribute('data-nombre') || '';
        apellidoInput.value = selectedEmpleado?.getAttribute('data-apellido') || '';

        const selectedDepto = selectDepartamento.options[selectDepartamento.selectedIndex];
        departamentoInput.value = selectedDepto?.getAttribute('data-descripcion') || '';
    }

    // Obtiene los costos del departamento seleccionado
    selectDepartamento.addEventListener('change', function() {
        const deptoId = this.value;
        if (!deptoId) {
            inputAlimentacion.value = inputAlojamiento.value = inputCombustible.value = 0;
            return;
        }

        fetch(`<?= base_url('departamento/ajaxCosto') ?>/${deptoId}`)
            .then(res => res.json())
            .then(data => {
                inputAlimentacion.value = data.alimentacion ?? 0;
                inputAlojamiento.value = data.alojamiento ?? 0;
                inputCombustible.value = data.combustible ?? 0;
            })
            .catch(err => {
                console.error('Error al obtener costos del departamento:', err);
            });
    });

    // Inicializar valores al cargar la página
    updateHiddenFields();
    selectDepartamento.dispatchEvent(new Event('change'));

    selectEmpleado.addEventListener('change', updateHiddenFields);
});
</script>

</body>
</html>