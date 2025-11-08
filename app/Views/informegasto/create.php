<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-plus-circle"></i> <?= esc($title); ?></h1>
    </div>
    <div class="card-body">
        
        <!-- Mostrar errores de validación -->
        <?php $validation = \Config\Services::validation(); ?>
        <?php if ($validation->getErrors()): ?>
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Creación (Apunta al método store del controlador) -->
        <?= form_open('informegasto/store'); ?>
            
            <div class="row">
                <!-- ID Empleado -->
                <div class="col-md-6 mb-3">
                    <label for="id_empleado" class="form-label">Empleado</label>
                    <select class="form-control" id="id_empleado" name="id_empleado" required>
                        <option value="">Seleccione un Empleado</option>
                        <?php foreach ($empleados as $empleado): ?>
                            <option value="<?= $empleado['id_empleado']; ?>" 
                                <?= set_select('id_empleado', $empleado['id_empleado']); ?>>
                                <?= esc($empleado['nombre']) . ' ' . esc($empleado['apellido']); ?> (DPI: <?= esc($empleado['dpi']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- ID Departamento (Asumiendo que existe una tabla de departamentos) -->
                <div class="col-md-6 mb-3">
                    <label for="id_departamento" class="form-label">Departamento</label>
                    <select class="form-control" id="id_departamento" name="id_departamento" required>
                        <option value="">Seleccione un Departamento</option>
                        <?php foreach ($departamentos as $depto): ?>
                            <option value="<?= $depto['id_departamento']; ?>" 
                                <?= set_select('id_departamento', $depto['id_departamento']); ?>>
                                <?= esc($depto['nombre_departamento']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Fecha de Visita -->
            <div class="mb-3">
                <label for="fecha_visita" class="form-label">Fecha de la Visita</label>
                <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" 
                       value="<?= set_value('fecha_visita'); ?>" required>
            </div>

            <h5 class="mt-4 mb-3 text-primary">Detalle de Gastos (Ingrese valores en moneda local)</h5>
            
            <div class="row">
                <!-- Alimentación -->
                <div class="col-md-3 mb-3">
                    <label for="alimentacion" class="form-label">Alimentación</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="alimentacion" name="alimentacion" 
                           value="<?= set_value('alimentacion', 0.00); ?>" required>
                </div>

                <!-- Alojamiento -->
                <div class="col-md-3 mb-3">
                    <label for="alojamiento" class="form-label">Alojamiento</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="alojamiento" name="alojamiento" 
                           value="<?= set_value('alojamiento', 0.00); ?>" required>
                </div>

                <!-- Combustible -->
                <div class="col-md-3 mb-3">
                    <label for="combustible" class="form-label">Combustible</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="combustible" name="combustible" 
                           value="<?= set_value('combustible', 0.00); ?>" required>
                </div>

                <!-- Otros -->
                <div class="col-md-3 mb-3">
                    <label for="otros" class="form-label">Otros Gastos</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="otros" name="otros" 
                           value="<?= set_value('otros', 0.00); ?>" required>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end mt-4">
                <a href="<?= base_url('informegasto'); ?>" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Informe
                </button>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>