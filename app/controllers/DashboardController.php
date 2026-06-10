<?php
/**
 * Controlador: DashboardController
 * Muestra el panel principal con estadísticas
 */

class DashboardController
{
    private $clienteModel;
    private $proyectoModel;

    public function __construct()
    {
        $this->clienteModel  = new Cliente();
        $this->proyectoModel = new Proyecto();
    }

    /**
     * Mostrar el dashboard principal
     */
    public function index()
    {
        // Obtener estadísticas
        $totalClientes   = $this->clienteModel->contar();
        $totalProyectos  = $this->proyectoModel->contar();
        $enProgreso      = $this->proyectoModel->contarPorEstado('En Progreso');
        $completados     = $this->proyectoModel->contarPorEstado('Completado');

        // Obtener últimos proyectos para mostrar en el dashboard
        $ultimosProyectos = $this->proyectoModel->obtenerTodos();
        $ultimosProyectos = array_slice($ultimosProyectos, 0, 5);

        // Datos para la vista
        $pageTitle = 'Dashboard';
        $currentPage = 'dashboard';

        // Cargar vista
        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/dashboard.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }
}
