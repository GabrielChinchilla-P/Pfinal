<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary text-white">
        <h1 class="h3 mb-0"><i class="fa-solid fa-edit"></i> <?= esc($title); ?> - ID: <?= esc($departamento['id_departamento']); ?></h1>
    </div>
    <div class="card-body">
        
        <!-- Mostrar errores de validación -->
        <?php $validation = \Config\Services::validation(); ?>
        <?php if ($validation->getErrors()): ?>
            <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de Edición (Apunta al método update con el ID del departamento) -->
        <?= form_open('departamento/update/' . $departamento['id_departamento']); ?>
            
            <!-- Nombre del Departamento -->
            <div class="mb-3">
                <label for="nombre_departamento" class="form-label">Nombre del Departamento</label>
                <input type="text" class="form-control" id="nombre_departamento" name="nombre_departamento" 
                       value="<?= set_value('nombre_departamento', $departamento['nombre_departamento']); ?>" 
                       required maxlength="150">
            </div>

            <!-- Distancia en Kilómetros -->
            <div class="mb-3">
                <label for="distancia_km" class="form-label">Distancia desde Oficina Central (en Km)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="distancia_km" name="distancia_km" 
                       value="<?= set_value('distancia_km', $departamento['distancia_km']); ?>" required>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end mt-4">
                <a href="<?= base_url('departamento'); ?>" class="btn btn-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-warning">
                    <i class="fa-solid fa-sync-alt"></i> Departamento
                </button>
            </div>

        <?= form_close(); ?>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>