
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fa-solid fa-file-invoice-dollar"></i> Nómina</h3>
        <a href="<?= base_url('nomina/create') ?>" class="btn btn-success">
            <i class="fa-solid fa-circle-plus"></i> Nueva nómina
        </a>
    </div>

<?php if(session()->getFlashdata('msg')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

    <table class="table table-striped table-bordered">
        <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Departamento</th>
                <th>Sueldo Base</th>
                <th>Bonificación</th>
                <th>IGSS</th>
                <th>Otros Desc.</th>
                <th>Líquido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($nominas)): ?>
                <?php foreach ($nominas as $n): ?>
                    <tr>
                        <td><?= $n['id_nomina'] ?></td>
                        <td><?= esc($n['nombre_empleado']) ?></td>
                        <td><?= esc($n['departamento']) ?></td>
                        <td>Q<?= number_format($n['sueldo_base'], 2) ?></td>
                        <td>Q<?= number_format($n['bonificacion'], 2) ?></td>
                        <td>Q<?= number_format($n['IGSS'], 2) ?></td>
                        <td>Q<?= number_format($n['otros_desc'], 2) ?></td>
                        <td><strong>Q<?= number_format($n['liquido'], 2) ?></strong></td>
                        <td class="text-center">
                            <a href="<?= base_url('nomina/edit/'.$n['id_nomina']) ?>" class="btn btn-warning btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="<?= base_url('nomina/delete/'.$n['id_nomina']) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Seguro que desea eliminar este registro?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9" class="text-center">No hay registros de nómina</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

