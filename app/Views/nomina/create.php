<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h1 class="h4 mb-0"><i class="fa-solid fa-calculator"></i> <?= esc($title); ?></h1>
    </div>

    <div class="card-body">

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

        <!-- Formulario de Cálculo de Nómina -->
        <form action="<?= base_url('nomina/store'); ?>" method="post">
            <?= csrf_field(); ?>

            <div class="row">
                <!-- Columna Izquierda: Empleado y Mes -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="id_empleado">Empleado (*)</label>
                        <select name="id_empleado" id="id_empleado" class="form-control" required>
                            <option value="">Seleccione un Empleado</option>
                            <?php if (!empty($empleados)): ?>
                                <?php foreach ($empleados as $empleado): ?>
                                    <option value="<?= esc($empleado['id_usuario']); ?>"
                                        <?= set_select('id_empleado', $empleado['id_usuario']); ?>>
                                        <?= esc($empleado['nombre']); ?> 
                                        (<?= esc($empleado['usuario']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No hay empleados registrados</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="mes">Mes de Pago (*)</label>
                        <input type="text" name="mes" id="mes" class="form-control"
                            placeholder="Ej: Octubre 2025" required
                            value="<?= set_value('mes', date('F Y')); ?>">
                    </div>
                </div>

                <!-- Columna Derecha: Valores Monetarios -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="sueldo_base">Sueldo Base (*)</label>
                        <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="form-control"
                            required value="<?= set_value('sueldo_base'); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="bonificacion">Bonificación (opcional)</label>
                        <input type="number" step="0.01" name="bonificacion" id="bonificacion" class="form-control"
                            value="<?= set_value('bonificacion', 0); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="descuentos">Otros Descuentos (opcional)</label>
                        <input type="number" step="0.01" name="descuentos" id="descuentos" class="form-control"
                            value="<?= set_value('descuentos', 0); ?>">
                    </div>

                    <p class="text-info mt-4">
                        <i class="fa-solid fa-circle-info"></i> El IGSS se calcula automáticamente (4.83% sobre Sueldo Base).
                    </p>
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i> Registrar y Calcular Nómina
            </button>
            <a href="<?= base_url('nomina'); ?>" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>