<!-- Formulario: Editar Proyecto -->
<div class="slide-in">
    <div class="card" style="max-width: 800px;">
        <div class="card-header">
            <h2>✏️ Editar Proyecto</h2>
            <a href="<?php echo url('proyectos', 'index'); ?>" class="btn btn-secondary btn-sm">
                ← Volver
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo url('proyectos', 'edit', ['id' => $proyecto['id']]); ?>" id="formEditarProyecto">
                <div class="form-group">
                    <label for="nombre">Nombre del Proyecto *</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control"
                        placeholder="Ingresa el nombre del proyecto"
                        value="<?php echo sanitize($proyecto['nombre']); ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="form-control"
                        placeholder="Describe brevemente el proyecto..."
                    ><?php echo sanitize($proyecto['descripcion'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="cliente_id">Cliente *</label>
                    <select id="cliente_id" name="cliente_id" class="form-control" required>
                        <option value="">— Seleccionar cliente —</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option
                                value="<?php echo $cliente['id']; ?>"
                                <?php echo ($proyecto['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>
                            >
                                <?php echo sanitize($cliente['nombre']); ?>
                                <?php if (!empty($cliente['empresa'])): ?>
                                    (<?php echo sanitize($cliente['empresa']); ?>)
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio *</label>
                        <input
                            type="date"
                            id="fecha_inicio"
                            name="fecha_inicio"
                            class="form-control"
                            value="<?php echo sanitize($proyecto['fecha_inicio']); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin">Fecha de Fin</label>
                        <input
                            type="date"
                            id="fecha_fin"
                            name="fecha_fin"
                            class="form-control"
                            value="<?php echo sanitize($proyecto['fecha_fin'] ?? ''); ?>"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control">
                            <?php
                            $estados = ['Pendiente', 'En Progreso', 'Completado', 'Cancelado'];
                            foreach ($estados as $estado): ?>
                                <option value="<?php echo $estado; ?>" <?php echo ($proyecto['estado'] ?? '') === $estado ? 'selected' : ''; ?>>
                                    <?php echo $estado; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="presupuesto">Presupuesto (S/)</label>
                        <input
                            type="number"
                            id="presupuesto"
                            name="presupuesto"
                            class="form-control"
                            placeholder="0.00"
                            step="0.01"
                            min="0"
                            value="<?php echo sanitize($proyecto['presupuesto'] ?? '0'); ?>"
                        >
                    </div>
                </div>

                <div class="btn-group mt-3">
                    <button type="submit" class="btn btn-primary" id="btnActualizarProyecto">
                        💾 Actualizar Proyecto
                    </button>
                    <a href="<?php echo url('proyectos', 'index'); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
