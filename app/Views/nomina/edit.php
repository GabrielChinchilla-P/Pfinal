<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h1 class="h4 mb-0"><i class="fa-solid fa-pen-to-square"></i> <?= esc($title); ?></h1>
    </div>
    <div class="card-body">
        
        <!-- Mensaje de Edición -->
        <div class="alert alert-warning">
            Estás editando la nómina #<strong><?= esc($nomina['id_nomina']); ?></strong>.
            El Sueldo Líquido y el IGSS se recalculan al guardar.
        </div>

        <!-- Manejo de Errores de Validación -->
        <?php if ($validation->getErrors()): ?>
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">¡Error de Validación!</h4>
                <ul>
                    <?php foreach ($validation->getErrors() as $error): ?>
                        <li><?= esc($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formulario de Edición de Nómina -->
        <!-- La URL de acción apunta al método update con el ID de la nómina -->
        <form action="<?= base_url('nomina/update/' . $nomina['id_nomina']); ?>" method="post">
            <?= csrf_field(); ?>
            <!-- Puedes agregar un campo oculto para mantener el ID, aunque ya está en la URL -->
            <input type="hidden" name="id_nomina" value="<?= esc($nomina['id_nomina']); ?>">

            <div class="row">
                <!-- Columna Izquierda: Empleado y Mes -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="id_empleado">Empleado (*)</label>
                        <select name="id_empleado" id="id_empleado" class="form-control" required>
                            <option value="">Seleccione un Empleado</option>
                            <?php foreach ($empleados as $empleado): ?>
                                <!-- Usamos set_select para mantener el valor si falla la validación -->
                                <!-- Si no hay old data, usamos el valor guardado en $nomina -->
                                <option value="<?= esc($empleado['id_usuario']); ?>" 
                                    <?= set_select('id_empleado', $empleado['id_usuario'], $empleado['id_usuario'] == old('id_empleado', $nomina['id_empleado'])); ?>>
                                    <?= esc($empleado['nombre']); ?> (<?= esc($empleado['usuario']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="mes">Mes de Pago (*)</label>
                        <input type="text" name="mes" id="mes" class="form-control" placeholder="Ej: Octubre 2024" required 
                            value="<?= set_value('mes', $nomina['mes']); ?>">
                    </div>
                </div>

                <!-- Columna Derecha: Valores Monetarios -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="sueldo_base">Sueldo Base (*)</label>
                        <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="form-control" required
                            value="<?= set_value('sueldo_base', $nomina['sueldo_base']); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="bonificacion">Bonificación (opcional)</label>
                        <input type="number" step="0.01" name="bonificacion" id="bonificacion" class="form-control" 
                            value="<?= set_value('bonificacion', $nomina['bonificacion']); ?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="descuentos">Otros Descuentos (opcional)</label>
                        <input type="number" step="0.01" name="descuentos" id="descuentos" class="form-control" 
                            value="<?= set_value('descuentos', $nomina['descuentos']); ?>">
                    </div>
                    
                    <p class="text-info mt-4">
                        <i class="fa-solid fa-circle-info"></i> El **IGSS** y el **Sueldo Líquido** se recalcularán al guardar.
                    </p>
                </div>
            </div>

            <hr>
            
            <button type="submit" class="btn btn-warning"><i class="fa-solid fa-arrow-up-right-from-square"></i> Actualizar Nómina</button>
            <a href="<?= base_url('nomina'); ?>" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>