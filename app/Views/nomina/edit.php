    <h3><i class="fa-solid fa-pen-to-square"></i> Editar Nómina</h3>
    <form action="<?= base_url('nomina/update/'.$nomina['id_nomina']) ?>" method="post" class="mt-3">

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Empleado</label>
                <input type="text" class="form-control" value="<?= esc($nomina['nombre_empleado']) ?>" readonly>
            </div>
            <div class="col-md-6">
                <label>Departamento</label>
                <input type="text" class="form-control" name="departamento" value="<?= esc($nomina['departamento']) ?>" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Sueldo Base (Q)</label>
                <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="form-control" value="<?= esc($nomina['sueldo_base']) ?>">
            </div>
            <div class="col-md-4">
                <label>Bonificación (Q)</label>
                <input type="number" step="0.01" name="bonificacion" id="bonificacion" class="form-control" value="<?= esc($nomina['bonificacion']) ?>">
            </div>
            <div class="col-md-4">
                <label>Otros Descuentos (Q)</label>
                <input type="number" step="0.01" name="otros_desc" id="otros_desc" class="form-control" value="<?= esc($nomina['otros_desc']) ?>">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>IGSS (4.83%)</label>
                <input type="number" step="0.01" name="IGSS" id="IGSS" class="form-control" value="<?= esc($nomina['IGSS']) ?>" readonly>
            </div>
            <div class="col-md-4">
                <label>Total Líquido (Q)</label>
                <input type="number" step="0.01" name="liquido" id="liquido" class="form-control" value="<?= esc($nomina['liquido']) ?>" readonly>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i> Actualizar
            </button>
            <a href="<?= base_url('nomina') ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sueldoBase = document.getElementById('sueldo_base');
    const bonificacion = document.getElementById('bonificacion');
    const otrosDesc = document.getElementById('otros_desc');
    const igss = document.getElementById('IGSS');
    const liquido = document.getElementById('liquido');

    [sueldoBase, bonificacion, otrosDesc].forEach(input => {
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