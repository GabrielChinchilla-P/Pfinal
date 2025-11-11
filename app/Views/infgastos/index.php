<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0 text-primary">
            <i class="fa-solid fa-file-invoice-dollar me-2"></i> Listado de Informes de Gastos
        </h3>
        <a href="<?= site_url('informegasto/create') ?>" class="btn btn-success btn-sm">
            <i class="fa-solid fa-plus me-1"></i> Crear Nuevo Informe
        </a>
    </div>
    <div class="card-body">

        <!-- 🔍 Formulario de búsqueda -->
        <form action="<?= site_url('informegasto/buscar') ?>" method="get" class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control"
                       placeholder="Buscar por empleado o departamento"
                       value="<?= esc($searchQuery ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="fecha_inicio" class="form-control"
                       value="<?= esc($fecha_inicio ?? '') ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="fecha_fin" class="form-control"
                       value="<?= esc($fecha_fin ?? '') ?>">
            </div>
            <div class="col-md-2 d-flex">
                <button type="submit" class="btn btn-outline-secondary me-2 w-100">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
                <?php if (!empty($searchQuery) || !empty($fecha_inicio) || !empty($fecha_fin)): ?>
                    <a href="<?= site_url('informegasto') ?>"
                       class="btn btn-outline-danger w-100"
                       title="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($informes)): ?>
            <div class="alert alert-info text-center">No se encontraron informes de gastos.</div>
        <?php else: ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID Informe</th>
                        <th>Empleado</th>
                        <th>Departamento</th>
                        <th>Fecha Visita</th>
                        <th>Alimentación</th>
                        <th>Alojamiento</th>
                        <th>Combustible</th>
                        <th>Otros</th>
                        <th>Total</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sum_alimentacion = 0;
                    $sum_alojamiento = 0;
                    $sum_combustible = 0;
                    $sum_otros = 0;
                    $sum_total = 0;

                    foreach ($informes as $i):
                        $alimentacion = (float) ($i['alimentacion'] ?? 0);
                        $alojamiento  = (float) ($i['alojamiento'] ?? 0);
                        $combustible  = (float) ($i['combustible'] ?? 0);
                        $otros        = (float) ($i['otros'] ?? 0);
                        $total        = $alimentacion + $alojamiento + $combustible + $otros;

                        $sum_alimentacion += $alimentacion;
                        $sum_alojamiento  += $alojamiento;
                        $sum_combustible  += $combustible;
                        $sum_otros        += $otros;
                        $sum_total        += $total;
                    ?>
                    <tr>
                        <td><?= esc($i['id_informe'] ?? 'N/A') ?></td>
                        <td><?= esc(($i['nombre_empleado'] ?? '') . ' ' . ($i['apellido_empleado'] ?? '')) ?></td>
                        <td><?= esc($i['nombre_departamento'] ?? 'N/A') ?></td>
                        <td><?= esc($i['fecha_visita'] ?? 'N/A') ?></td>
                        <td>Q<?= number_format($alimentacion, 2) ?></td>
                        <td>Q<?= number_format($alojamiento, 2) ?></td>
                        <td>Q<?= number_format($combustible, 2) ?></td>
                        <td>Q<?= number_format($otros, 2) ?></td>
                        <td class="<?= $total > 1000 ? 'text-danger fw-bold' : '' ?>">
                            Q<?= number_format($total, 2) ?>
                        </td>
                        <td><?= esc(substr($i['descripcion'] ?? '', 0, 50)) ?><?= strlen($i['descripcion'] ?? '') > 50 ? '...' : '' ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('informegasto/edit/' . ($i['id_informe'] ?? '')) ?>"
                               class="btn btn-primary btn-sm me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm"
                                onclick="if(confirm('¿Eliminar <?= esc($i['id_informe'] ?? '') ?>?')){ document.getElementById('delete-form-<?= esc($i['id_informe'] ?? 'temp') ?>').submit(); }">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                            <form id="delete-form-<?= esc($i['id_informe'] ?? 'temp') ?>"
                                  action="<?= site_url('informegasto/delete/' . ($i['id_informe'] ?? '')) ?>"
                                  method="post" style="display:none;">
                                <input type="hidden" name="_method" value="DELETE">
                                <?= csrf_field() ?>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

                <!-- Totales -->
                <tfoot class="table-light fw-bold text-center">
                    <tr>
                        <td colspan="4" class="text-end">Totales:</td>
                        <td>Q<?= number_format($sum_alimentacion, 2) ?></td>
                        <td>Q<?= number_format($sum_alojamiento, 2) ?></td>
                        <td>Q<?= number_format($sum_combustible, 2) ?></td>
                        <td>Q<?= number_format($sum_otros, 2) ?></td>
                        <td>Q<?= number_format($sum_total, 2) ?></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <?php endif; ?>
    </div>
</div>