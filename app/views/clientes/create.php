<!-- Formulario: Nuevo Cliente -->
<div class="slide-in">
    <div class="card" style="max-width: 800px;">
        <div class="card-header">
            <h2>➕ Registrar Nuevo Cliente</h2>
            <a href="<?php echo url('clientes', 'index'); ?>" class="btn btn-secondary btn-sm">
                ← Volver
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo url('clientes', 'create'); ?>" id="formCliente">
                <div class="form-group">
                    <label for="nombre">Nombre Completo *</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control"
                        placeholder="Ingresa el nombre del cliente"
                        value="<?php echo sanitize($_POST['nombre'] ?? ''); ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Correo Electrónico *</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="cliente@email.com"
                            value="<?php echo sanitize($_POST['email'] ?? ''); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input
                            type="text"
                            id="telefono"
                            name="telefono"
                            class="form-control"
                            placeholder="987654321"
                            value="<?php echo sanitize($_POST['telefono'] ?? ''); ?>"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="empresa">Empresa</label>
                    <input
                        type="text"
                        id="empresa"
                        name="empresa"
                        class="form-control"
                        placeholder="Nombre de la empresa"
                        value="<?php echo sanitize($_POST['empresa'] ?? ''); ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input
                        type="text"
                        id="direccion"
                        name="direccion"
                        class="form-control"
                        placeholder="Dirección del cliente"
                        value="<?php echo sanitize($_POST['direccion'] ?? ''); ?>"
                    >
                </div>

                <div class="btn-group mt-3">
                    <button type="submit" class="btn btn-primary" id="btnGuardarCliente">
                        💾 Guardar Cliente
                    </button>
                    <a href="<?php echo url('clientes', 'index'); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
