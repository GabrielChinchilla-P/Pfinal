<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' | ' : '' ?>Sistema Visitas Médicas</title>

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
<div class="container py-4">
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Registrar Informe de Gastos</h3>
    </div>
    <div class="card-body">

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('informegasto/store') ?>" class="row g-3">
            
            <div class="col-md-4">
                <label for="id_empleado" class="form-label">Empleado</label>
                <select name="id_empleado" class="form-select" required>
                    <option value="">Seleccione Empleado</option>
                    <?php foreach($empleados as $e): ?>
                    <option value="<?= $e['cod_empleado'] ?>" 
                        data-nombre="<?= esc($e['nombre']) ?>" 
                        data-apellido="<?= esc($e['apellido']) ?>"
                        <?= old('id_empleado') == $e['cod_empleado'] ? 'selected' : '' ?> >
                        <?= $e['cod_empleado'] ?> - <?= esc($e['nombre'].' '.$e['apellido']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-4">
                <label for="id_departamento" class="form-label">Departamento de Visita</label>
                <select name="id_departamento" id="id_departamento" class="form-select" required>
                    <option value="">Seleccione Departamento</option>
                    <?php foreach($departamentos as $d): ?>
                    <option value="<?= $d['depto'] ?>"
                        data-descripcion="<?= esc($d['descripcion']) ?>"
                        <?= old('id_departamento') == $d['depto'] ? 'selected' : '' ?> >
                        <?= $d['depto'] ?> - <?= esc($d['descripcion']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="fecha_visita" class="form-label">Fecha de Visita</label>
                <input type="date" name="fecha_visita" class="form-control" required value="<?= old('fecha_visita') ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label text-muted">Alimentación (Fijo/BD)</label>
                <input type="number" name="alimentacion" step="0.01" class="form-control" value="0.00" readonly>
            </div>
            
            <div class="col-md-3">
                <label class="form-label text-muted">Alojamiento (Fijo/BD)</label>
                <input type="number" name="alojamiento" step="0.01" class="form-control" value="0.00" readonly>
            </div>
            
            <div class="col-md-3">
                <label class="form-label text-muted">Combustible (Fijo/BD)</label>
                <input type="number" name="combustible" step="0.01" class="form-control" value="0.00" readonly>
            </div>

            <div class="col-md-3">
                <label for="otros" class="form-label text-primary">Otros Gastos (Variable)</label>
                <input type="number" name="otros" step="0.01" class="form-control" value="<?= old('otros') ?? 0.00 ?>" required>
            </div>

            <div class="col-12">
                <label for="descripcion" class="form-label">Descripción de la Visita</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Detalles de la visita" required value="<?= old('descripcion') ?>">
            </div>
            
            <div class="col-12 text-end">
                <a href="<?= base_url('informegasto') ?>" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Informe
                </button>
            </div>

            <!-- Campos ocultos -->
            <input type="hidden" name="nombre_empleado_hidden" id="nombre_empleado_hidden">
            <input type="hidden" name="apellido_empleado_hidden" id="apellido_empleado_hidden">
            <input type="hidden" name="nombre_departamento_hidden" id="nombre_departamento_hidden">

        </form>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectEmpleado = document.querySelector('select[name="id_empleado"]');
    const selectDepartamento = document.querySelector('select[name="id_departamento"]');

    const nombreInput = document.getElementById('nombre_empleado_hidden');
    const apellidoInput = document.getElementById('apellido_empleado_hidden');
    const departamentoInput = document.getElementById('nombre_departamento_hidden');

    const inputAlimentacion = document.querySelector('input[name="alimentacion"]');
    const inputAlojamiento = document.querySelector('input[name="alojamiento"]');
    const inputCombustible = document.querySelector('input[name="combustible"]');

    function updateHiddenFields() {
        const selectedEmpleadoOption = selectEmpleado.options[selectEmpleado.selectedIndex];
        nombreInput.value = selectedEmpleadoOption?.getAttribute('data-nombre') || '';
        apellidoInput.value = selectedEmpleadoOption?.getAttribute('data-apellido') || '';

        const selectedDepartamentoOption = selectDepartamento.options[selectDepartamento.selectedIndex];
        departamentoInput.value = selectedDepartamentoOption?.getAttribute('data-descripcion') || '';
    }

    selectDepartamento.addEventListener('change', function() {
        const deptoId = this.value;
        if(!deptoId) {
            inputAlimentacion.value = 0;
            inputAlojamiento.value = 0;
            inputCombustible.value = 0;
            return;
        }

        fetch(`<?= base_url('departamento/ajaxCosto') ?>/${deptoId}`)
            .then(res => res.json())
            .then(data => {
                const alimentacion = parseFloat(data.alimentacion) || 0;
                const alojamiento = parseFloat(data.alojamiento) || 0;
                const combustible = parseFloat(data.combustible) || 0;

                inputAlimentacion.value = alimentacion;
                inputAlojamiento.value = alojamiento;
                inputCombustible.value = combustible;

                // Mostrar alerta solo si todos los valores son 0
                if(alimentacion === 0 && alojamiento === 0 && combustible === 0) {
                    alert('No se encontraron costos fijos para este departamento.');
                }
            })
            .catch(err => {
                console.error('Error al obtener costos del departamento:', err);
                inputAlimentacion.value = 0;
                inputAlojamiento.value = 0;
                inputCombustible.value = 0;
            });
    });

    // Inicializar valores ocultos y campos de costos
    updateHiddenFields();
    selectDepartamento.dispatchEvent(new Event('change'));
    selectEmpleado.addEventListener('change', updateHiddenFields);
});
</script>
</body>
</html>