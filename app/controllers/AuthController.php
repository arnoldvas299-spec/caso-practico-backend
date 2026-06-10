<?php
/**
 * Controlador: AuthController
 * Gestiona el registro, login y logout de usuarios
 */

class AuthController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    /**
     * Mostrar formulario de login
     */
    public function login()
    {
        // Si ya está logueado, redirigir al dashboard
        if (isLoggedIn()) {
            redirect('index.php?controller=dashboard&action=index');
        }

        // Procesar formulario de login (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validación
            if (empty($email) || empty($password)) {
                setFlash('danger', 'Por favor, completa todos los campos.');
            } else {
                // Buscar usuario por email
                $usuario = $this->usuarioModel->buscarPorEmail($email);

                if ($usuario && $this->usuarioModel->verificarPassword($password, $usuario['password'])) {
                    // Login exitoso: crear sesión
                    $_SESSION['user_id']    = $usuario['id'];
                    $_SESSION['user_name']  = $usuario['nombre'];
                    $_SESSION['user_email'] = $usuario['email'];

                    setFlash('success', '¡Bienvenido, ' . $usuario['nombre'] . '!');
                    redirect('index.php?controller=dashboard&action=index');
                } else {
                    setFlash('danger', 'Email o contraseña incorrectos.');
                }
            }
        }

        // Mostrar vista de login
        require_once ROOT_PATH . '/app/views/auth/login.php';
    }

    /**
     * Mostrar formulario de registro
     */
    public function register()
    {
        // Si ya está logueado, redirigir al dashboard
        if (isLoggedIn()) {
            redirect('index.php?controller=dashboard&action=index');
        }

        // Procesar formulario de registro (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre          = trim($_POST['nombre'] ?? '');
            $email           = trim($_POST['email'] ?? '');
            $password        = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validaciones
            if (empty($nombre) || empty($email) || empty($password) || empty($confirmPassword)) {
                setFlash('danger', 'Por favor, completa todos los campos.');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                setFlash('danger', 'El formato del email no es válido.');
            } elseif (strlen($password) < 6) {
                setFlash('danger', 'La contraseña debe tener al menos 6 caracteres.');
            } elseif ($password !== $confirmPassword) {
                setFlash('danger', 'Las contraseñas no coinciden.');
            } elseif ($this->usuarioModel->emailExiste($email)) {
                setFlash('danger', 'Este email ya está registrado.');
            } else {
                // Registrar usuario
                if ($this->usuarioModel->registrar($nombre, $email, $password)) {
                    setFlash('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
                    redirect('index.php?controller=auth&action=login');
                } else {
                    setFlash('danger', 'Ocurrió un error al registrar el usuario.');
                }
            }
        }

        // Mostrar vista de registro
        require_once ROOT_PATH . '/app/views/auth/register.php';
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        // Destruir todas las variables de sesión
        $_SESSION = [];

        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        // Redirigir al login
        header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
        exit;
    }
}
