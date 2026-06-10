<!-- Listado de Clientes -->
<div class="slide-in">
    <div class="card">
        <div class="card-header">
            <h2>👥 Listado de Clientes</h2>
            <a href="<?php echo url('clientes', 'create'); ?>" class="btn btn-primary btn-sm">
                ➕ Nuevo Cliente
            </a>
        </div>

        <div class="table-responsive">
            <table class="table" id="tablaClientes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Empresa</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">👥</div>
                                    <h3>No hay clientes registrados</h3>
                                    <p>Comienza registrando tu primer cliente.</p>
                                    <a href="<?php echo url('clientes', 'create'); ?>" class="btn btn-primary btn-sm">
                                        ➕ Registrar Cliente
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><strong><?php echo $i; ?></strong></td>
                                <td><strong><?php echo sanitize($cliente['nombre']); ?></strong></td>
                                <td><?php echo sanitize($cliente['email']); ?></td>
                                <td><?php echo sanitize($cliente['telefono'] ?? '—'); ?></td>
                                <td><?php echo sanitize($cliente['empresa'] ?? '—'); ?></td>
                                <td><?php echo formatDate($cliente['created_at']); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo url('clientes', 'edit', ['id' => $cliente['id']]); ?>" class="btn btn-warning btn-sm" title="Editar">
                                            ✏️ Editar
                                        </a>
                                        <form method="POST" action="<?php echo url('clientes', 'delete'); ?>" class="delete-form" onsubmit="return confirm('¿Estás seguro de eliminar a este cliente? Se eliminarán también sus proyectos.')">
                                            <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
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
