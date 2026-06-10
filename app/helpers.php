<?php
/**
 * Funciones auxiliares del sistema
 */

/**
 * Verificar si el usuario está logueado
 * @return bool
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Redirigir a una URL del sistema
 * @param string $path Ruta relativa (ej: 'index.php?controller=auth&action=login')
 */
function redirect($path)
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

/**
 * Sanitizar datos de entrada para evitar XSS
 * @param string $data
 * @return string
 */
function sanitize($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Establecer un mensaje flash en la sesión
 * @param string $type Tipo de mensaje: success, danger, warning, info
 * @param string $message Contenido del mensaje
 */
function setFlash($type, $message)
{
    $_SESSION['flash'] = [
        'type'    => $type,
        'message' => $message
    ];
}

/**
 * Obtener y eliminar el mensaje flash de la sesión
 * @return array|null
 */
function getFlash()
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Generar URL completa para el sistema
 * @param string $controller
 * @param string $action
 * @param array $params Parámetros adicionales
 * @return string
 */
function url($controller = '', $action = '', $params = [])
{
    $url = BASE_URL . 'index.php';

    if ($controller) {
        $url .= '?controller=' . $controller;
        if ($action) {
            $url .= '&action=' . $action;
        }
        foreach ($params as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }
    }

    return $url;
}

/**
 * Formatear fecha a formato legible
 * @param string $date
 * @return string
 */
function formatDate($date)
{
    if (empty($date)) return '—';
    return date('d/m/Y', strtotime($date));
}

/**
 * Formatear moneda
 * @param float $amount
 * @return string
 */
function formatMoney($amount)
{
    return 'S/ ' . number_format($amount, 2, '.', ',');
}
