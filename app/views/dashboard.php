<!-- Dashboard Principal -->
<div class="slide-in">

    <!-- Tarjetas de estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👥</div>
            <div class="stat-info">
                <h3><?php echo $totalClientes; ?></h3>
                <p>Clientes Registrados</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">📁</div>
            <div class="stat-info">
                <h3><?php echo $totalProyectos; ?></h3>
                <p>Total de Proyectos</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">🔄</div>
            <div class="stat-info">
                <h3><?php echo $enProgreso; ?></h3>
                <p>En Progreso</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">✅</div>
            <div class="stat-info">
                <h3><?php echo $completados; ?></h3>
                <p>Completados</p>
            </div>
        </div>
    </div>

    <!-- Últimos Proyectos -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>📋 Últimos Proyectos</h2>
            <a href="<?php echo url('proyectos', 'index'); ?>" class="btn btn-secondary btn-sm">
                Ver todos →
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Presupuesto</th>
                        <th>Fecha Inicio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ultimosProyectos)): ?>
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 40px;">
                                No hay proyectos registrados aún.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ultimosProyectos as $proyecto): ?>
                            <tr>
                                <td><strong><?php echo sanitize($proyecto['nombre']); ?></strong></td>
                                <td><?php echo sanitize($proyecto['cliente_nombre']); ?></td>
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
                                <td><?php echo formatMoney($proyecto['presupuesto']); ?></td>
                                <td><?php echo formatDate($proyecto['fecha_inicio']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">⚡ Accesos Rápidos</h2>
    <div class="quick-actions">
        <a href="<?php echo url('clientes', 'create'); ?>" class="quick-action-card">
            <div class="action-icon" style="background: var(--primary-50); color: var(--primary);">➕</div>
            <div>
                <h4>Nuevo Cliente</h4>
                <p>Registrar un cliente</p>
            </div>
        </a>

        <a href="<?php echo url('proyectos', 'create'); ?>" class="quick-action-card">
            <div class="action-icon" style="background: var(--success-light); color: var(--success);">📝</div>
            <div>
                <h4>Nuevo Proyecto</h4>
                <p>Crear un proyecto</p>
            </div>
        </a>

        <a href="<?php echo url('reportes', 'index'); ?>" class="quick-action-card">
            <div class="action-icon" style="background: var(--warning-light); color: var(--warning);">📄</div>
            <div>
                <h4>Generar Reporte</h4>
                <p>Descargar PDF</p>
            </div>
        </a>

        <a href="<?php echo url('clientes', 'index'); ?>" class="quick-action-card">
            <div class="action-icon" style="background: #f3e8ff; color: #7c3aed;">📋</div>
            <div>
                <h4>Ver Clientes</h4>
                <p>Listado completo</p>
            </div>
        </a>
    </div>

</div>
