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








</div>