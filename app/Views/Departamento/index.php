<?= view('templates/header') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Gestión de Departamentos</h2>

    <!-- 🔙 Botón regresar al menú -->
    <div class="text-center mb-3">
        <a href="<?= base_url('/menu'); ?>" class="btn btn-warning">
            <i class="bi bi-arrow-left-circle"></i> Regresar al Menú Principal
        </a>
    </div>

    <!-- 🪪 Botón créditos -->
    <div class="text-center mb-4">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreditos">
            <i class="bi bi-people-fill"></i> Ver Créditos del Equipo
        </button>
    </div>

    <!-- Alertas -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- Barra de búsqueda -->
    <form class="d-flex mb-3" method="get" action="<?= base_url('/departamentos/buscar'); ?>">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar por código o descripción...">
        <button class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?= base_url('/departamentos'); ?>" class="btn btn-secondary ms-2"><i class="bi bi-arrow-clockwise"></i> Limpiar</a>
    </form>

    <!-- Botón nuevo -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalDepartamento">
        <i class="bi bi-plus-circle"></i> Nuevo Departamento
    </button>

    <!-- Tabla -->
    <table id="tablaDepartamentos" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                <th>Código</th>
                <th>Descripción</th>
                <th>Distancia (km)</th>
                <th>Alojamiento (Q)</th>
                <th>Combustible (Q)</th>
                <th>Alimentación (Q)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departamentos as $d): ?>
            <tr class="text-center">
                <td><?= esc($d['depto']) ?></td>
                <td><?= esc($d['descripcion']) ?></td>
                <td><?= esc($d['distancia']) ?></td>
                <td><?= esc($d['alojamiento']) ?></td>
                <td><?= esc($d['combustible']) ?></td>
                <td><?= esc($d['alimentacion']) ?></td>
                <td>
                    <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDepartamento"
                            data-id="<?= esc($d['depto']) ?>"
                            data-descripcion="<?= esc($d['descripcion']) ?>"
                            data-distancia="<?= esc($d['distancia']) ?>"
                            data-alojamiento="<?= esc($d['alojamiento']) ?>"
                            data-combustible="<?= esc($d['combustible']) ?>"
                            data-alimentacion="<?= esc($d['alimentacion']) ?>">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <a href="<?= base_url('/departamentos/delete/' . $d['depto']); ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Seguro que desea eliminar este departamento?')">
                       <i class="bi bi-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
