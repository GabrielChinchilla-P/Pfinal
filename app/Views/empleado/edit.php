<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-warning text-dark">
        <h1 class="h4 mb-0"><i class="fa-solid fa-pen-to-square"></i> <?= esc($title); ?></h1>
    </div>
    <div class="card-body">
        
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

        <!-- La URL de acción apunta al método update con el ID del empleado -->
        <form action="<?= base_url('empleado/update/' . $empleado['id_empleado']); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id_empleado" value="<?= esc($empleado['id_empleado']); ?>">

            <div class="row">
                <!-- Columna Izquierda: Datos Personales -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre (*)</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required
                            value="<?= set_value('nombre', $empleado['nombre']); ?>" placeholder="Ingrese nombre(s)">
                    </div>

                    <div class="form-group mb-3">
                        <label for="apellido">Apellido (*)</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required
                            value="<?= set_value('apellido', $empleado['apellido']); ?>" placeholder="Ingrese apellido(s)">
                    </div>

                    <div class="form-group mb-3">
                        <label for="dpi">DPI/Identificación (*)</label>
                        <input type="text" name="dpi" id="dpi" class="form-control" required
                            value="<?= set_value('dpi', $empleado['dpi']); ?>" placeholder="DPI único (20 caracteres max)">
                    </div>
                </div>

                <!-- Columna Derecha: Puesto y Sueldo -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="puesto">Puesto (*)</label>
                        <input type="text" name="puesto" id="puesto" class="form-control" required
                            value="<?= set_value('puesto', $empleado['puesto']); ?>" placeholder="Ej: Médico General, Asistente">
                    </div>

                    <div class="form-group mb-3">
                        <label for="sueldo_base">Sueldo Base (*)</label>
                        <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="form-control" required
                            value="<?= set_value('sueldo_base', $empleado['sueldo_base']); ?>" placeholder="Sueldo base mensual">
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_usuario">Usuario de Acceso (Cuenta Log-in) (*)</label>
                        <select name="id_usuario" id="id_usuario" class="form-control" required>
                            <option value="">Seleccione un Usuario</option>
                            <?php 
                            // Unimos la lista de usuarios libres con el usuario actualmente asignado
                            $currentUserId = $empleado['id_usuario'];
                            ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <?php 
                                    $isSelected = ($usuario['id_usuario'] == old('id_usuario', $currentUserId));
                                ?>
                                <option value="<?= esc($usuario['id_usuario']); ?>" <?= set_select('id_usuario', $usuario['id_usuario'], $isSelected); ?>>
                                    <?= esc($usuario['usuario']); ?> (<?= esc($usuario['nombre']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <hr>
            
            <button type="submit" class="btn btn-warning"><i class="fa-solid fa-arrow-up-right-from-square"></i> Actualizar Empleado</button>
            <a href="<?= base_url('empleado'); ?>" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>