<?php $this->extend('templates/main'); ?>

<?php $this->section('content'); ?>
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Editar Bonificación #<?= esc($bonificacion['id_bonificacion'] ?? 'N/A'); ?></h1>
        <a href="<?= base_url('bonificacion'); ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
            ← Volver al Listado
        </a>
    </div>

    <!-- Incluye el formulario base con el diseño correcto -->
    <?= $this->include('bonificacion/form'); ?>
</div>
<?php $this->endSection(); ?>