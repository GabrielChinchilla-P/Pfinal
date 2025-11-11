<h2>Lista de Bonificaciones</h2>

<a href="<?= base_url('bonificacion/create') ?>" class="btn btn-success mb-3">Nueva Bonificación</a>

<?php if(!empty($bonificaciones)): ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Visitador</th>
            <th>Nombre</th>
            <th>Ventas Totales</th>
            <th>Bonificación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($bonificaciones as $b): ?>
        <tr>
            <td><?= esc($b['id_visitador']) ?></td>
            <td><?= esc($b['nombre_visitador']) ?></td>
            <td>Q<?= number_format($b['ventas_totales'],2) ?></td>
            <td>Q<?= number_format($b['bonificacion'],2) ?></td>
            <td>
                <a href="<?= base_url('bonificacion/edit/'.$b['id']) ?>" class="btn btn-primary btn-sm">Editar</a>
                <a href="<?= base_url('bonificacion/delete/'.$b['id']) ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('¿Está seguro de eliminar esta bonificación?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>No hay bonificaciones registradas.</p>
<?php endif; ?>