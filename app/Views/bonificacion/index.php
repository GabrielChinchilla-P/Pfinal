<?php $this->extend('templates/main'); ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Bonificación por Ventas</h2>

    <!-- 🪪 Botón Créditos -->
    <div class="text-center mb-4">
        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCreditos">
            <i class="bi bi-people-fill"></i> Ver Créditos del Equipo
        </button>
    </div>

     <!-- ✅ Alertas -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <!-- 🔍 Buscar -->
    <form class="d-flex mb-3" method="get" action="<?= base_url('/bonificacion/buscar'); ?>">
        <input type="text" name="q" class="form-control me-2" placeholder="Buscar por ID o nombre...">
        <button class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?= base_url('/bonificacion'); ?>" class="btn btn-secondary ms-2"><i class="bi bi-arrow-clockwise"></i> Limpiar</a>
    </form>

    <!-- 🟢 Botón nuevo -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalBonificacion">
        <i class="bi bi-plus-circle"></i> Nueva Bonificación
    </button>

    <!-- 📋 Tabla -->
    <table id="tablaBonificacion" class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>ID Visitador</th>
                <th>Nombre Visitador</th>
                <th>Ventas Totales (Q)</th>
                <th>Bonificación (Q)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bonificacion as $b): ?>
            <tr>
                <td><?= esc($b['id_visitador']) ?></td>
                <td><?= esc($b['nombre_visitador']) ?></td>
                <td><?= number_format($b['ventas_totales'], 2) ?></td>
                <td><?= number_format($b['bonificacion'], 2) ?></td>
                <td class="text-center">
                    <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalBonificacion"
                            data-id="<?= esc($b['id_visitador']) ?>"
                            data-nombre="<?= esc($b['nombre_visitador']) ?>"
                            data-ventas="<?= esc($b['ventas_totales']) ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <a href="<?= base_url('/bonificacion/delete/' . $b['id_visitador']); ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Está seguro de eliminar esta bonificación?')">
                       <i class="bi bi-trash3"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>