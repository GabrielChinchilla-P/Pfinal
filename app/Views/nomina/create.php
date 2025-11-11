<div class="container mt-4">
    <h3><i class="fa-solid fa-user-plus"></i> Registrar Nómina</h3>
    <form action="<?= base_url('nomina/store') ?>" method="post" class="mt-3">

<div class="row mb-3">
    <div class="col-md-6">
        <label>Empleado</label>
        <select name="nombre_empleado" class="form-select" required>
            <option value="">Seleccione un empleado</option>
            <?php foreach ($empleados as $e): ?>
                <option 
                    value="<?= esc($e['nombre'] . ' ' . $e['apellido']) ?>"
                    data-cod="<?= esc($e['cod_empleado']) ?>"
                    data-dep="<?= esc($e['departamento']) ?>"
                    data-sueldo="0"> <!-- Si tu tabla no tiene sueldo_base -->
                    <?= esc($e['nombre'] . ' ' . $e['apellido']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Código empleado</label>
        <input type="text" name="cod_empleado" id="cod_empleado" class="form-control" readonly>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <label>Departamento</label>
        <input type="text" name="departamento" id="departamento" class="form-control" readonly>
    </div>
</div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Sueldo Base (Q)</label>
                <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Bonificación (Q)</label>
                <input type="number" step="0.01" name="bonificacion" id="bonificacion" class="form-control" value="250.00">
            </div>
            <div class="col-md-4">
                <label>Otros Descuentos (Q)</label>
                <input type="number" step="0.01" name="otros_desc" id="otros_desc" class="form-control" value="0.00">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>IGSS (4.83%)</label>
                <input type="number" step="0.01" name="IGSS" id="IGSS" class="form-control" readonly>
            </div>
            <div class="col-md-4">
                <label>Total Líquido (Q)</label>
                <input type="number" step="0.01" name="liquido" id="liquido" class="form-control" readonly>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i> Guardar Registro
            </button>
            <a href="<?= base_url('nomina') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const empleadoSelect = document.querySelector('select[name="nombre_empleado"]');
    const codEmpleado = document.getElementById('cod_empleado');
    const departamento = document.getElementById('departamento');
    const sueldoBase = document.getElementById('sueldo_base');
    const bonificacion = document.getElementById('bonificacion');
    const otrosDesc = document.getElementById('otros_desc');
    const igss = document.getElementById('IGSS');
    const liquido = document.getElementById('liquido');

    // Cargar datos del empleado
    empleadoSelect.addEventListener('change', () => {
        const selected = empleadoSelect.options[empleadoSelect.selectedIndex];
        codEmpleado.value = selected.dataset.cod || '';
        departamento.value = selected.dataset.dep || '';
        sueldoBase.value = selected.dataset.sueldo || 0;
        calcularTotales();
    });

    // Recalcular totales
    [bonificacion, otrosDesc].forEach(input => {
        input.addEventListener('input', calcularTotales);
    });

    function calcularTotales() {
        const sueldo = parseFloat(sueldoBase.value) || 0;
        const bono = parseFloat(bonificacion.value) || 0;
        const otros = parseFloat(otrosDesc.value) || 0;

        const igssCalc = sueldo * 0.0483;
        const liquidoCalc = sueldo + bono - igssCalc - otros;

        igss.value = igssCalc.toFixed(2);
        liquido.value = liquidoCalc.toFixed(2);
    }
});
</script>