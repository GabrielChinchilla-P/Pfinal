<div class="bg-white p-8 rounded-xl shadow-2xl max-w-2xl mx-auto">
    <!-- El formulario apunta a 'update' si existe ID, o a 'store' si es nuevo -->
    <?php if (isset($bonificacion)): ?>
        <form action="<?= base_url('bonificacion/update/' . $bonificacion['id_bonificacion']); ?>" method="post">
    <?php else: ?>
        <form action="<?= base_url('bonificacion/store'); ?>" method="post">
    <?php endif; ?>
    
    <div class="space-y-6">
        <!-- Campo ID Empleado -->
        <div>
            <label for="id_empleado" class="block text-sm font-medium text-gray-700 mb-1">Empleado</label>
            <select name="id_empleado" id="id_empleado" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150">
                <option value="">-- Seleccione un Empleado --</option>
                <?php 
                // Asume que la variable $empleados está disponible desde el controlador
                $selected_id = old('id_empleado') ?? ($bonificacion['id_empleado'] ?? '');
                if (isset($empleados) && is_array($empleados)):
                    foreach ($empleados as $empleado): ?>
                        <option 
                            value="<?= esc($empleado['id_empleado']); ?>" 
                            <?= ($selected_id == $empleado['id_empleado']) ? 'selected' : ''; ?>
                        >
                            <?= esc($empleado['nombre'] . ' ' . $empleado['apellido']); ?>
                        </option>
                    <?php endforeach;
                endif;
                ?>
            </select>
        </div>

        <!-- Campo Ventas del Mes -->
        <div>
            <label for="ventas_mes" class="block text-sm font-medium text-gray-700 mb-1">Ventas del Mes ($)</label>
            <input 
                type="number" 
                name="ventas_mes" 
                id="ventas_mes" 
                step="0.01"
                min="0"
                required 
                value="<?= esc(old('ventas_mes') ?? ($bonificacion['ventas_mes'] ?? '')); ?>"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
            >
        </div>

        <!-- Campo Porcentaje -->
        <div>
            <label for="porcentaje" class="block text-sm font-medium text-gray-700 mb-1">Porcentaje de Bonificación (Ej: 0.10 para 10%)</label>
            <input 
                type="number" 
                name="porcentaje" 
                id="porcentaje" 
                step="0.01"
                min="0"
                max="1"
                required 
                value="<?= esc(old('porcentaje') ?? ($bonificacion['porcentaje'] ?? '')); ?>"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
            >
        </div>

        <!-- Campo Monto (Solo lectura, calculado en el controlador) -->
        <?php if (isset($bonificacion)): ?>
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">Monto de la Bonificación (Calculado)</label>
                <input 
                    type="text" 
                    id="monto" 
                    value="$<?= number_format(esc($bonificacion['monto']), 2); ?>"
                    readonly 
                    class="mt-1 block w-full border border-gray-200 bg-gray-50 rounded-lg shadow-sm p-3 text-lg font-bold text-green-700"
                >
            </div>
        <?php endif; ?>

        <!-- Botones de Acción -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105">
                <?= isset($bonificacion) ? 'Actualizar Bonificación' : 'Guardar Bonificación'; ?>
            </button>
        </div>
    </div>
    </form>
</div>