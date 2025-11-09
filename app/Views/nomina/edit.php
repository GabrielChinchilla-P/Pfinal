<?= $this->include('layouts/header'); ?>

<div class="card shadow-lg">
    <div class="card-header py-3 bg-warning text-dark">
        <h1 class="h4 mb-0"><i class="fa-solid fa-pen-to-square"></i> <?= esc($title); ?></h1>
    </div>

    <div class="card-body">
        <!-- Mensaje de Edición -->
        <div class="alert alert-warning">
            Estás editando la nómina #<strong><?= esc($nomina->id_nomina); ?></strong>.
            El Sueldo Líquido y el IGSS se recalculan al guardar.
        </div>

        <!-- Manejo de Errores de Validación -->
        <?php if (isset($validation) && $validation->getErrors()): ?>
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">¡Error de Validación!</h4>
            <ul>
                <?php foreach ($validation->getErrors() as $error): ?>
                <li><?= esc($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Formulario de Edición -->
        <form action="<?= base_url('nomina/update/' . $nomina->id_nomina); ?>" method="post" class="row g-3">

            <div class="col-md-6">
                <label for="id_empleado" class="form-label">Empleado</label>
                <select name="id_empleado" id="id_empleado" class="form-select" required>
                    <option value="">Seleccione un empleado...</option>

                    <?php foreach ($empleados as $empleado): ?>
                    <option value="<?= $empleado['id_usuario']; ?>"
                        <?= ($empleado['id_usuario'] == $nomina->id_empleado) ? 'selected' : ''; ?>>
                        <?= esc($empleado['nombre'] . ' (' . $empleado['usuario'] . ')'); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="salario_base" class="form-label">Salario Base (Q)</label>
                <input type="number" step="0.01" class="form-control" id="salario_base" name="salario_base"
                    value="<?= esc($nomina->salario_base); ?>" required>
            </div>

            <div class="col-md-3">
                <label for="bonificacion" class="form-label">Bonificación (Q)</label>
                <input type="number" step="0.01" class="form-control" id="bonificacion" name="bonificacion"
                    value="<?= esc($nomina->bonificacion); ?>" required>
            </div>

            <div class="col-md-3">
                <label for="igss" class="form-label">IGSS (Q)</label>
                <input type="number" step="0.01" class="form-control" id="igss" name="igss"
                    value="<?= esc($nomina->igss); ?>" readonly>
            </div>

            <div class="col-md-3">
                <label for="sueldo_liquido" class="form-label">Sueldo Líquido (Q)</label>
                <input type="number" step="0.01" class="form-control" id="sueldo_liquido" name="sueldo_liquido"
                    value="<?= esc($nomina->sueldo_liquido); ?>" readonly>
            </div>

            <div class="col-md-6">
                <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                <input type="date" class="form-control" id="fecha_pago" name="fecha_pago"
                    value="<?= esc($nomina->fecha_pago); ?>" required>
            </div>

            <div class="col-12 mt-3 text-end">
                <a href="<?= base_url('nomina'); ?>" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>