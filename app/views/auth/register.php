<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Crear una cuenta en el Sistema de Gestión">
    <title>Registro | Sistema de Gestión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="logo-icon">⚡</div>
                <h1>Crear Cuenta</h1>
                <p>Regístrate para acceder al sistema</p>
            </div>

            <?php
            $flash = getFlash();
            if ($flash): ?>
                <div class="flash-message flash-<?php echo $flash['type']; ?>">
                    <?php
                    $icons = ['success' => '✅', 'danger' => '❌', 'warning' => '⚠️', 'info' => 'ℹ️'];
                    echo $icons[$flash['type']] ?? '';
                    ?>
                    <?php echo sanitize($flash['message']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo url('auth', 'register'); ?>" id="registerForm">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="form-control"
                        placeholder="Ingresa tu nombre completo"
                        value="<?php echo sanitize($_POST['nombre'] ?? ''); ?>"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="tu@email.com"
                        value="<?php echo sanitize($_POST['email'] ?? ''); ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Mínimo 6 caracteres"
                        required
                        minlength="6"
                    >
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña</label>
                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        class="form-control"
                        placeholder="Repite tu contraseña"
                        required
                        minlength="6"
                    >
                </div>

                <button type="submit" class="btn btn-primary btn-block" id="btnRegister">
                    Crear Cuenta
                </button>
            </form>

            <div class="auth-footer">
                ¿Ya tienes una cuenta?
                <a href="<?php echo url('auth', 'login'); ?>">Inicia sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
