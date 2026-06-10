<?php
/**
 * Controlador: ProyectoController
 * Gestiona el CRUD completo de proyectos
 */

class ProyectoController
{
    private $proyectoModel;
    private $clienteModel;

    public function __construct()
    {
        $this->proyectoModel = new Proyecto();
        $this->clienteModel  = new Cliente();
    }

    /**
     * Listar todos los proyectos
     */
    public function index()
    {
        $proyectos = $this->proyectoModel->obtenerTodos();
        $pageTitle = 'Proyectos';
        $currentPage = 'proyectos';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/proyectos/index.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Mostrar formulario de creación y procesar el registro
     */
    public function create()
    {
        // Obtener clientes para el select
        $clientes = $this->clienteModel->obtenerTodos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'       => trim($_POST['nombre'] ?? ''),
                'descripcion'  => trim($_POST['descripcion'] ?? ''),
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'fecha_fin'    => $_POST['fecha_fin'] ?? null,
                'estado'       => $_POST['estado'] ?? 'Pendiente',
                'presupuesto'  => $_POST['presupuesto'] ?? 0,
                'cliente_id'   => (int) ($_POST['cliente_id'] ?? 0)
            ];

            // Validaciones
            if (empty($datos['nombre'])) {
                setFlash('danger', 'El nombre del proyecto es obligatorio.');
            } elseif (empty($datos['fecha_inicio'])) {
                setFlash('danger', 'La fecha de inicio es obligatoria.');
            } elseif ($datos['cliente_id'] <= 0) {
                setFlash('danger', 'Debes seleccionar un cliente.');
            } else {
                if (empty($datos['fecha_fin'])) {
                    $datos['fecha_fin'] = null;
                }

                if ($this->proyectoModel->crear($datos)) {
                    setFlash('success', 'Proyecto registrado exitosamente.');
                    redirect('index.php?controller=proyectos&action=index');
                } else {
                    setFlash('danger', 'Error al registrar el proyecto.');
                }
            }
        }

        $pageTitle = 'Nuevo Proyecto';
        $currentPage = 'proyectos';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/proyectos/create.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Mostrar formulario de edición y procesar la actualización
     */
    public function edit()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id <= 0) {
            setFlash('danger', 'Proyecto no encontrado.');
            redirect('index.php?controller=proyectos&action=index');
        }

        $proyecto = $this->proyectoModel->obtenerPorId($id);

        if (!$proyecto) {
            setFlash('danger', 'Proyecto no encontrado.');
            redirect('index.php?controller=proyectos&action=index');
        }

        // Obtener clientes para el select
        $clientes = $this->clienteModel->obtenerTodos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre'       => trim($_POST['nombre'] ?? ''),
                'descripcion'  => trim($_POST['descripcion'] ?? ''),
                'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
                'fecha_fin'    => $_POST['fecha_fin'] ?? null,
                'estado'       => $_POST['estado'] ?? 'Pendiente',
                'presupuesto'  => $_POST['presupuesto'] ?? 0,
                'cliente_id'   => (int) ($_POST['cliente_id'] ?? 0)
            ];

            // Validaciones
            if (empty($datos['nombre'])) {
                setFlash('danger', 'El nombre del proyecto es obligatorio.');
            } elseif (empty($datos['fecha_inicio'])) {
                setFlash('danger', 'La fecha de inicio es obligatoria.');
            } elseif ($datos['cliente_id'] <= 0) {
                setFlash('danger', 'Debes seleccionar un cliente.');
            } else {
                if (empty($datos['fecha_fin'])) {
                    $datos['fecha_fin'] = null;
                }

                if ($this->proyectoModel->actualizar($id, $datos)) {
                    setFlash('success', 'Proyecto actualizado exitosamente.');
                    redirect('index.php?controller=proyectos&action=index');
                } else {
                    setFlash('danger', 'Error al actualizar el proyecto.');
                }
            }

            // Recargar datos
            $proyecto = array_merge($proyecto, $datos);
        }

        $pageTitle = 'Editar Proyecto';
        $currentPage = 'proyectos';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/proyectos/edit.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Eliminar un proyecto
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

            if ($id > 0) {
                if ($this->proyectoModel->eliminar($id)) {
                    setFlash('success', 'Proyecto eliminado exitosamente.');
                } else {
                    setFlash('danger', 'Error al eliminar el proyecto.');
                }
            }
        }

        redirect('index.php?controller=proyectos&action=index');
    }
}
