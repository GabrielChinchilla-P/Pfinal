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






</div>