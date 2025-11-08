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
                <!-- Se usa listErrors() para mostrar los errores generados en el controlador -->
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Creación (Apunta al método store del controlador) -->
        <?= form_open('departamento/store'); ?>
            
            <!-- Nombre del Departamento -->
            <div class="mb-3">
                <label for="nombre_departamento" class="form-label">Nombre del Departamento</label>
                <input type="text" class="form-control" id="nombre_departamento" name="nombre_departamento" 
                       value="<?= set_value('nombre_departamento'); ?>" required maxlength="150">
            </div>

            <!-- Distancia en Kilómetros -->
            <div class="mb-3">
                <label for="distancia_km" class="form-label">Distancia desde Oficina Central (en Km)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="distancia_km" name="distancia_km" 
                       value="<?= set_value('distancia_km', 0.00); ?>" required>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end mt-4">
                <a href="<?= base_url('departamento'); ?>" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Departamento
                </button>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>