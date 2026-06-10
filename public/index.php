<?php
/**
 * Front Controller - Punto de entrada principal
 * Todas las peticiones pasan por aquí
 */

// Iniciar sesión
session_start();

// Definir constantes
define('BASE_URL', getenv('BASE_URL') ?: '/caso-practico-backend/public/');
define('ROOT_PATH', dirname(__DIR__));

// Cargar configuración de base de datos
require_once ROOT_PATH . '/config/database.php';

// Cargar funciones auxiliares
require_once ROOT_PATH . '/app/helpers.php';

// Cargar autoload de Composer (para Dompdf)
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}

// Cargar modelos
require_once ROOT_PATH . '/app/models/Usuario.php';
require_once ROOT_PATH . '/app/models/Cliente.php';
require_once ROOT_PATH . '/app/models/Proyecto.php';

// Obtener controlador y acción de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Si no hay controlador definido, redirigir según estado de sesión
if (empty($controller)) {
    if (isLoggedIn()) {
        $controller = 'dashboard';
        $action = 'index';
    } else {
        $controller = 'auth';
        $action = 'login';
    }
}

// Si no hay acción definida, usar 'index' por defecto
if (empty($action)) {
    $action = 'index';
}

// Rutas públicas (no requieren autenticación)
$publicRoutes = ['auth'];

// Middleware de autenticación
if (!in_array($controller, $publicRoutes) && !isLoggedIn()) {
    setFlash('warning', 'Debes iniciar sesión para acceder al sistema.');
    redirect('index.php?controller=auth&action=login');
}

// Enrutar a los controladores
switch ($controller) {
    case 'auth':
        require_once ROOT_PATH . '/app/controllers/AuthController.php';
        $ctrl = new AuthController();
        break;

    case 'dashboard':
        require_once ROOT_PATH . '/app/controllers/DashboardController.php';
        $ctrl = new DashboardController();
        break;

    case 'clientes':
        require_once ROOT_PATH . '/app/controllers/ClienteController.php';
        $ctrl = new ClienteController();
        break;

    case 'proyectos':
        require_once ROOT_PATH . '/app/controllers/ProyectoController.php';
        $ctrl = new ProyectoController();
        break;

    case 'reportes':
        require_once ROOT_PATH . '/app/controllers/ReporteController.php';
        $ctrl = new ReporteController();
        break;

    default:
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
        echo '<p>La página que buscas no existe.</p>';
        echo '<a href="' . BASE_URL . '">Volver al inicio</a>';
        exit;
}

// Ejecutar la acción del controlador
if (method_exists($ctrl, $action)) {
    $ctrl->$action();
} else {
    http_response_code(404);
    echo '<h1>404 - Acción no encontrada</h1>';
    echo '<p>La acción solicitada no existe.</p>';
    echo '<a href="' . BASE_URL . '">Volver al inicio</a>';
    exit;
}
