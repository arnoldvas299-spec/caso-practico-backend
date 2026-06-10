<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gestión - Caso Práctico Backend Developer Web">
    <title><?php echo isset($pageTitle) ? sanitize($pageTitle) . ' | ' : ''; ?>Sistema de Gestión</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <div class="app-container">

        <!-- Overlay para menú móvil -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-content">
                    <div class="brand-icon">⚡</div>
                    <div>
                        <h2>GestiónPro</h2>
                        <small>Panel de Control</small>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Principal</div>
                    <a href="<?php echo url('dashboard', 'index'); ?>" class="nav-link <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>">
                        <span class="nav-icon">📊</span>
                        Dashboard
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Gestión</div>
                    <a href="<?php echo url('clientes', 'index'); ?>" class="nav-link <?php echo ($currentPage ?? '') === 'clientes' ? 'active' : ''; ?>">
                        <span class="nav-icon">👥</span>
                        Clientes
                    </a>
                    <a href="<?php echo url('proyectos', 'index'); ?>" class="nav-link <?php echo ($currentPage ?? '') === 'proyectos' ? 'active' : ''; ?>">
                        <span class="nav-icon">📁</span>
                        Proyectos
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Documentos</div>
                    <a href="<?php echo url('reportes', 'index'); ?>" class="nav-link <?php echo ($currentPage ?? '') === 'reportes' ? 'active' : ''; ?>">
                        <span class="nav-icon">📄</span>
                        Reportes PDF
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Cuenta</div>
                    <a href="<?php echo url('auth', 'logout'); ?>" class="nav-link" onclick="return confirm('¿Estás seguro de que deseas cerrar sesión?')">
                        <span class="nav-icon">🚪</span>
                        Cerrar Sesión
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?php echo sanitize($_SESSION['user_name'] ?? 'Usuario'); ?></div>
                        <div class="user-email"><?php echo sanitize($_SESSION['user_email'] ?? ''); ?></div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Contenido principal -->
        <main class="main-content">
            <div class="content-header">
                <div>
                    <button class="menu-toggle" id="menuToggle" onclick="toggleSidebar()">☰</button>
                    <h1><?php echo sanitize($pageTitle ?? 'Dashboard'); ?></h1>
                </div>
            </div>

            <div class="content-body fade-in">
                <?php
                // Mostrar mensajes flash
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
