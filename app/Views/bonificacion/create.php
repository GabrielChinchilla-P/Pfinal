<h2>Registrar Bonificación</h2>

<form method="post" action="<?= base_url('bonificacion/store') ?>" class="row g-3">
    <div class="col-md-6">
        <label>Empleado</label>
        <select name="cod_empleado" class="form-select" id="empleadoSelect" required>
            <option value="">Seleccione un empleado</option>
            <?php foreach($empleados as $e): ?>
                <option 
                    value="<?= esc($e['cod_empleado']) ?>"
                    data-nombre="<?= esc($e['nombre'].' '.$e['apellido']) ?>">
                    <?= esc($e['nombre'].' '.$e['apellido']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label>Nombre del Visitador</label>
        <input type="text" name="nombre_empleado" id="nombreEmpleado" class="form-control" readonly required>
    </div>
    <div class="col-md-3">
        <input type="number" name="ventas_totales" step="0.01" class="form-control" placeholder="Ventas Totales" required>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" placeholder="Bonificación" readonly>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success">Guardar</button>
    </div>
</form>

<script>
const empleadoSelect = document.getElementById('empleadoSelect');
const nombreEmpleado = document.getElementById('nombreEmpleado');
const ventasInput = document.querySelector('input[name="ventas_totales"]');
const bonifInput = document.querySelector('input[placeholder="Bonificación"]');

// Mostrar nombre al seleccionar empleado
empleadoSelect.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    nombreEmpleado.value = selected.getAttribute('data-nombre') || '';
});

// Calcular bonificación automáticamente
ventasInput.addEventListener('input', function() {
    const ventas = parseFloat(this.value) || 0;
    let bonif = 0;
    if (ventas > 40000) bonif = ventas * 0.15;
    else if (ventas > 25000) bonif = ventas * 0.10;
    else bonif = ventas * 0.05;
    bonifInput.value = bonif.toFixed(2);
});
</script>