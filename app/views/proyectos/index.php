<!-- Listado de Proyectos -->
<div class="slide-in">
    <div class="card">
        <div class="card-header">
            <h2>📁 Listado de Proyectos</h2>
            <a href="<?php echo url('proyectos', 'create'); ?>" class="btn btn-primary btn-sm">
                ➕ Nuevo Proyecto
            </a>
        </div>

        <div class="table-responsive">
            <table class="table" id="tablaProyectos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Proyecto</th>
                        <th>Cliente</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Presupuesto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($proyectos)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">📁</div>
                                    <h3>No hay proyectos registrados</h3>
                                    <p>Comienza creando tu primer proyecto.</p>
                                    <a href="<?php echo url('proyectos', 'create'); ?>" class="btn btn-primary btn-sm">
                                        ➕ Crear Proyecto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach ($proyectos as $proyecto): ?>
                            <tr>
                                <td><strong><?php echo $i; ?></strong></td>
                                <td>
                                    <strong><?php echo sanitize($proyecto['nombre']); ?></strong>
                                    <?php if (!empty($proyecto['descripcion'])): ?>
                                        <br><small style="color: var(--text-muted);"><?php echo sanitize(substr($proyecto['descripcion'], 0, 60)); ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo sanitize($proyecto['cliente_nombre']); ?></td>
                                <td><?php echo formatDate($proyecto['fecha_inicio']); ?></td>
                                <td><?php echo formatDate($proyecto['fecha_fin']); ?></td>
                                <td>
                                    <?php
                                    $badgeClass = '';
                                    switch ($proyecto['estado']) {
                                        case 'Pendiente': $badgeClass = 'badge-pendiente'; break;
                                        case 'En Progreso': $badgeClass = 'badge-progreso'; break;
                                        case 'Completado': $badgeClass = 'badge-completado'; break;
                                        case 'Cancelado': $badgeClass = 'badge-cancelado'; break;
                                    }
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo sanitize($proyecto['estado']); ?>
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <?php echo formatMoney($proyecto['presupuesto']); ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo url('proyectos', 'edit', ['id' => $proyecto['id']]); ?>" class="btn btn-warning btn-sm" title="Editar">
                                            ✏️ Editar
                                        </a>
                                        <form method="POST" action="<?php echo url('proyectos', 'delete'); ?>" class="delete-form" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')">
                                            <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
