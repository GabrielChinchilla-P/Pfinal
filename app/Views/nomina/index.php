<?= $this->include('layouts/header'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary">
        <i class="fa-solid fa-money-bill-wave"></i> Nómina de Empleados
    </h3>
    <a href="<?= base_url('nomina/create'); ?>" class="btn btn-success">
        <i class="fa-solid fa-plus-circle"></i> Nueva Nómina
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fa-solid fa-circle-check"></i> <?= session()->getFlashdata('success'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fa-solid fa-triangle-exclamation"></i> <?= session()->getFlashdata('error'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Mes</th>
                        <th>Sueldo Base</th>
                        <th>Bonificación</th>
                        <th>IGSS</th>
                        <th>Descuentos</th>
                        <th>Sueldo Líquido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($nominas)): ?>
                    <?php foreach ($nominas as $nomina): ?>
                    <tr>
                        <td><?= esc($nomina->id_nomina); ?></td>
                        <td><?= esc($nomina->nombre_empleado); ?> <small
                                class="text-muted">(<?= esc($nomina->nombre_usuario); ?>)</small></td>
                        <td><?= esc($nomina->mes); ?></td>
                        <td>$<?= number_format($nomina->sueldo_base, 2); ?></td>
                        <td>$<?= number_format($nomina->bonificacion, 2); ?></td>
                        <td>$<?= number_format($nomina->IGSS, 2); ?></td>
                        <td>$<?= number_format($nomina->descuentos, 2); ?></td>
                        <td><strong>$<?= number_format($nomina->sueldo_liquido, 2); ?></strong></td>
                        <td>
                            <a href="<?= base_url('nomina/edit/' . $nomina->id_nomina); ?>"
                                class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="<?= base_url('nomina/eliminar/' . $nomina->id_nomina); ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('¿Desea eliminar esta nómina?');">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No hay registros de nómina disponibles.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->include('layouts/footer'); ?>