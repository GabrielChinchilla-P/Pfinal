<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-edit"></i> <?= esc($title); ?> - ID: <?= esc($informe['id_gasto']); ?></h1>
    </div>
    <div class="card-body">
        
        <!-- Mostrar errores de validación -->
        <?php $validation = \Config\Services::validation(); ?>
        <?php if ($validation->getErrors()): ?>
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Edición (Apunta al método update con el ID del gasto) -->
        <?= form_open('informegasto/update/' . $informe['id_gasto']); ?>
            
            <div class="row">
                <!-- ID Empleado (Inhabilitado, para que no se cambie en la edición) -->
                <div class="col-md-6 mb-3">
                    <label for="id_empleado" class="form-label">Empleado</label>
                    <select class="form-control" id="id_empleado" name="id_empleado" disabled>
                        <?php foreach ($empleados as $empleado): ?>
                            <option value="<?= $empleado['id_empleado']; ?>" 
                                <?= ($empleado['id_empleado'] == $informe['id_empleado'] ? 'selected' : ''); ?>>
                                <?= esc($empleado['nombre']) . ' ' . esc($empleado['apellido']); ?> (DPI: <?= esc($empleado['dpi']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Campo oculto para enviar el valor real al controlador -->
                    <input type="hidden" name="id_empleado" value="<?= esc($informe['id_empleado']); ?>">
                </div>

                <!-- ID Departamento -->
                <div class="col-md-6 mb-3">
                    <label for="id_departamento" class="form-label">Departamento</label>
                    <select class="form-control" id="id_departamento" name="id_departamento" required>
                        <option value="">Seleccione un Departamento</option>
                        <?php foreach ($departamentos as $depto): ?>
                            <option value="<?= $depto['id_departamento']; ?>" 
                                <?= set_select('id_departamento', $depto['id_departamento'], ($depto['id_departamento'] == $informe['id_departamento'])); ?>>
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
                       value="<?= set_value('fecha_visita', $informe['fecha_visita']); ?>" required>
            </div>

            <h5 class="mt-4 mb-3 text-primary">Detalle de Gastos (Ingrese valores en moneda local)</h5>
            
            <div class="row">
                <!-- Alimentación -->
                <div class="col-md-3 mb-3">
                    <label for="alimentacion" class="form-label">Alimentación</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="alimentacion" name="alimentacion" 
                           value="<?= set_value('alimentacion', $informe['alimentacion']); ?>" required>
                </div>

                <!-- Alojamiento -->
                <div class="col-md-3 mb-3">
                    <label for="alojamiento" class="form-label">Alojamiento</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="alojamiento" name="alojamiento" 
                           value="<?= set_value('alojamiento', $informe['alojamiento']); ?>" required>
                </div>

                <!-- Combustible -->
                <div class="col-md-3 mb-3">
                    <label for="combustible" class="form-label">Combustible</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="combustible" name="combustible" 
                           value="<?= set_value('combustible', $informe['combustible']); ?>" required>
                </div>

                <!-- Otros -->
                <div class="col-md-3 mb-3">
                    <label for="otros" class="form-label">Otros Gastos</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="otros" name="otros" 
                           value="<?= set_value('otros', $informe['otros']); ?>" required>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end mt-4">
                <a href="<?= base_url('informegasto'); ?>" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-warning">
                    <i class="fa-solid fa-sync-alt"></i> Actualizar Informe
                </button>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>