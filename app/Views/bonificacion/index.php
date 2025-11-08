<?php $this->extend('templates/main'); ?>

<?php $this->section('content'); ?>
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-extrabold text-gray-900 border-b-4 border-indigo-600 pb-2">Bonificaciones de Empleados</h1>
        <a href="<?= base_url('bonificacion/create'); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Nueva Bonificación
        </a>
    </div>

    <!-- Barra de Búsqueda y Filtros -->
    <div class="mb-6 bg-white p-4 rounded-xl shadow-lg">
        <form action="<?= base_url('bonificacion'); ?>" method="get" class="flex items-center space-x-4">
            <input 
                type="text" 
                name="q" 
                placeholder="Buscar por empleado..." 
                value="<?= esc($searchQuery ?? '') ?>"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Buscar
            </button>
            <?php if ($searchQuery): ?>
                <a href="<?= base_url('bonificacion'); ?>" class="text-red-500 hover:text-red-700 font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Limpiar
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tabla de Listado -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-2xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Empleado</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Ventas del Mes</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Porcentaje</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Monto Calculado</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if (empty($bonificaciones)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No se encontraron bonificaciones.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bonificaciones as $bonificacion): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= esc($bonificacion['id_bonificacion']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= esc($bonificacion['nombre_empleado'] . ' ' . $bonificacion['apellido_empleado']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">$<?= number_format(esc($bonificacion['ventas_mes']), 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= number_format(esc($bonificacion['porcentaje']) * 100, 2); ?>%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">$<?= number_format(esc($bonificacion['monto']), 2); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="<?= base_url('bonificacion/edit/' . $bonificacion['id_bonificacion']); ?>" class="text-yellow-600 hover:text-yellow-800 transition duration-150 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="<?= base_url('bonificacion/delete/' . $bonificacion['id_bonificacion']); ?>" class="text-red-600 hover:text-red-800 transition duration-150" onclick="return confirm('¿Está seguro de que desea eliminar esta bonificación?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 100 2v6a1 1 0 100-2V8z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->endSection(); ?>