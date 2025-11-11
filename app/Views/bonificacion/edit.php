<h2>Editar Bonificación</h2>

<form method="post" action="<?= base_url('bonificacion/update/' . $bonificacion['id']) ?>" class="row g-3">
    <div class="col-md-6">
        <label>Empleado</label>
        <select name="cod_empleado" class="form-select" id="empleadoSelect" required>
            <option value="">Seleccione un empleado</option>
            <?php foreach ($empleados as $e): ?>
                <option 
                    value="<?= esc($e['cod_empleado']) ?>"
                    data-nombre="<?= esc($e['nombre'] . ' ' . $e['apellido']) ?>"
                    <?= $e['cod_empleado'] == $bonificacion['id_visitador'] ? 'selected' : '' ?>>
                    <?= esc($e['nombre'] . ' ' . $e['apellido']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Nombre del Visitador</label>
        <input 
            type="text" 
            name="nombre_empleado" 
            id="nombreEmpleado" 
            class="form-control" 
            readonly 
            required
            value="<?= esc($bonificacion['nombre_visitador']) ?>">
    </div>

    <div class="col-md-3">
        <label>Ventas Totales</label>
        <input 
            type="number" 
            name="ventas_totales" 
            step="0.01" 
            class="form-control" 
            id="ventasInput" 
            required
            value="<?= esc($bonificacion['ventas_totales']) ?>">
    </div>

    <div class="col-md-3">
        <label>Bonificación</label>
        <input 
            type="text" 
            name="bonificacion"
            class="form-control" 
            id="bonifInput" 
            readonly
            value="<?= esc($bonificacion['bonificacion']) ?>">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?= base_url('bonificacion') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<script>
const empleadoSelect = document.getElementById('empleadoSelect');
const nombreEmpleado = document.getElementById('nombreEmpleado');
const ventasInput = document.getElementById('ventasInput');
const bonifInput = document.getElementById('bonifInput');

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