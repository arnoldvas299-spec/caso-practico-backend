<?php
/**
 * Controlador: ClienteController
 * Gestiona el CRUD completo de clientes
 */

class ClienteController
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new Cliente();
    }

    /**
     * Listar todos los clientes
     */
    public function index()
    {
        $clientes = $this->clienteModel->obtenerTodos();
        $pageTitle = 'Clientes';
        $currentPage = 'clientes';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/clientes/index.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Mostrar formulario de creación y procesar el registro
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'empresa'   => trim($_POST['empresa'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            // Validaciones
            if (empty($datos['nombre']) || empty($datos['email'])) {
                setFlash('danger', 'El nombre y el email son obligatorios.');
            } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                setFlash('danger', 'El formato del email no es válido.');
            } else {
                if ($this->clienteModel->crear($datos)) {
                    setFlash('success', 'Cliente registrado exitosamente.');
                    redirect('index.php?controller=clientes&action=index');
                } else {
                    setFlash('danger', 'Error al registrar el cliente.');
                }
            }
        }

        $pageTitle = 'Nuevo Cliente';
        $currentPage = 'clientes';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/clientes/create.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Mostrar formulario de edición y procesar la actualización
     */
    public function edit()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id <= 0) {
            setFlash('danger', 'Cliente no encontrado.');
            redirect('index.php?controller=clientes&action=index');
        }

        $cliente = $this->clienteModel->obtenerPorId($id);

        if (!$cliente) {
            setFlash('danger', 'Cliente no encontrado.');
            redirect('index.php?controller=clientes&action=index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'email'     => trim($_POST['email'] ?? ''),
                'telefono'  => trim($_POST['telefono'] ?? ''),
                'empresa'   => trim($_POST['empresa'] ?? ''),
                'direccion' => trim($_POST['direccion'] ?? '')
            ];

            // Validaciones
            if (empty($datos['nombre']) || empty($datos['email'])) {
                setFlash('danger', 'El nombre y el email son obligatorios.');
            } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                setFlash('danger', 'El formato del email no es válido.');
            } else {
                if ($this->clienteModel->actualizar($id, $datos)) {
                    setFlash('success', 'Cliente actualizado exitosamente.');
                    redirect('index.php?controller=clientes&action=index');
                } else {
                    setFlash('danger', 'Error al actualizar el cliente.');
                }
            }

            // Recargar datos para mostrar los cambios en el formulario
            $cliente = array_merge($cliente, $datos);
        }

        $pageTitle = 'Editar Cliente';
        $currentPage = 'clientes';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/clientes/edit.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Eliminar un cliente
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

            if ($id > 0) {
                if ($this->clienteModel->eliminar($id)) {
                    setFlash('success', 'Cliente eliminado exitosamente.');
                } else {
                    setFlash('danger', 'Error al eliminar el cliente.');
                }
            }
        }

        redirect('index.php?controller=clientes&action=index');
    }
}
