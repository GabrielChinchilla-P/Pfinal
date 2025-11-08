<?= $this->include('layouts/header'); ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-success text-white">
        <h1 class="h4 mb-0"><i class="fa-solid fa-user-plus"></i> <?= esc($title); ?></h1>
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

        <form action="<?= base_url('empleado/store'); ?>" method="post">
            <?= csrf_field(); ?>

            <div class="row">
                <!-- Columna Izquierda: Datos Personales -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre (*)</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required
                            value="<?= set_value('nombre'); ?>" placeholder="Ingrese nombre(s)">
                    </div>

                    <div class="form-group mb-3">
                        <label for="apellido">Apellido (*)</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required
                            value="<?= set_value('apellido'); ?>" placeholder="Ingrese apellido(s)">
                    </div>

                    <div class="form-group mb-3">
                        <label for="dpi">DPI/Identificación (*)</label>
                        <input type="text" name="dpi" id="dpi" class="form-control" required
                            value="<?= set_value('dpi'); ?>" placeholder="DPI único (20 caracteres max)">
                    </div>
                </div>

                <!-- Columna Derecha: Puesto y Sueldo -->
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="puesto">Puesto (*)</label>
                        <input type="text" name="puesto" id="puesto" class="form-control" required
                            value="<?= set_value('puesto'); ?>" placeholder="Ej: Médico General, Asistente">
                    </div>

                    <div class="form-group mb-3">
                        <label for="sueldo_base">Sueldo Base (*)</label>
                        <input type="number" step="0.01" name="sueldo_base" id="sueldo_base" class="form-control" required
                            value="<?= set_value('sueldo_base'); ?>" placeholder="Sueldo base mensual">
                    </div>

                    <div class="form-group mb-3">
                        <label for="id_usuario">Usuario de Acceso (Cuenta Log-in) (*)</label>
                        <select name="id_usuario" id="id_usuario" class="form-control" required>
                            <option value="">Seleccione un Usuario</option>
                            <?php if (empty($usuariosLibres)): ?>
                                <option value="" disabled>-- No hay cuentas de usuario sin asignar --</option>
                            <?php else: ?>
                                <?php foreach ($usuariosLibres as $usuario): ?>
                                    <option value="<?= esc($usuario['id_usuario']); ?>" 
                                        <?= set_select('id_usuario', $usuario['id_usuario']); ?>>
                                        <?= esc($usuario['usuario']); ?> (<?= esc($usuario['nombre']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?php if (empty($usuariosLibres)): ?>
                             <small class="text-danger">Necesitas crear un nuevo usuario si deseas asignar una cuenta.</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr>
            
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Registrar Empleado</button>
            <a href="<?= base_url('empleado'); ?>" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>