<?php
/**
 * Controlador: ReporteController
 * Genera reportes PDF de clientes y proyectos usando Dompdf
 */

use Dompdf\Dompdf;
use Dompdf\Options;

class ReporteController
{
    private $clienteModel;
    private $proyectoModel;

    public function __construct()
    {
        $this->clienteModel  = new Cliente();
        $this->proyectoModel = new Proyecto();
    }

    /**
     * Mostrar página de reportes
     */
    public function index()
    {
        $pageTitle = 'Reportes';
        $currentPage = 'reportes';

        require_once ROOT_PATH . '/app/views/layouts/header.php';
        require_once ROOT_PATH . '/app/views/reportes/index.php';
        require_once ROOT_PATH . '/app/views/layouts/footer.php';
    }

    /**
     * Generar reporte PDF de clientes
     */
    public function clientes()
    {
        $clientes = $this->clienteModel->obtenerTodos();
        $fechaGeneracion = date('d/m/Y H:i:s');

        // Construir HTML del reporte
        $html = $this->getReportHeader('Reporte de Clientes', $fechaGeneracion);
        $html .= '
        <table>
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:20%">Nombre</th>
                    <th style="width:20%">Email</th>
                    <th style="width:12%">Teléfono</th>
                    <th style="width:20%">Empresa</th>
                    <th style="width:23%">Dirección</th>
                </tr>
            </thead>
            <tbody>';

        $i = 1;
        foreach ($clientes as $cliente) {
            $html .= '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . sanitize($cliente['nombre']) . '</td>
                    <td>' . sanitize($cliente['email']) . '</td>
                    <td>' . sanitize($cliente['telefono'] ?? '—') . '</td>
                    <td>' . sanitize($cliente['empresa'] ?? '—') . '</td>
                    <td>' . sanitize($cliente['direccion'] ?? '—') . '</td>
                </tr>';
            $i++;
        }

        $html .= '
            </tbody>
        </table>
        <div class="footer">
            <p>Total de clientes: <strong>' . count($clientes) . '</strong></p>
        </div>';
        $html .= $this->getReportFooter();

        // Generar PDF
        $this->generatePdf($html, 'Reporte_Clientes_' . date('Y-m-d'));
    }

    /**
     * Generar reporte PDF de proyectos
     */
    public function proyectos()
    {
        $proyectos = $this->proyectoModel->obtenerTodos();
        $fechaGeneracion = date('d/m/Y H:i:s');

        // Construir HTML del reporte
        $html = $this->getReportHeader('Reporte de Proyectos', $fechaGeneracion);
        $html .= '
        <table>
            <thead>
                <tr>
                    <th style="width:5%">#</th>
                    <th style="width:20%">Proyecto</th>
                    <th style="width:15%">Cliente</th>
                    <th style="width:12%">Inicio</th>
                    <th style="width:12%">Fin</th>
                    <th style="width:12%">Estado</th>
                    <th style="width:12%">Presupuesto</th>
                </tr>
            </thead>
            <tbody>';

        $totalPresupuesto = 0;
        $i = 1;
        foreach ($proyectos as $proyecto) {
            $totalPresupuesto += $proyecto['presupuesto'];

            // Clase de color para el estado
            $estadoStyle = '';
            switch ($proyecto['estado']) {
                case 'Completado':
                    $estadoStyle = 'color: #059669; font-weight: bold;';
                    break;
                case 'En Progreso':
                    $estadoStyle = 'color: #0284c7; font-weight: bold;';
                    break;
                case 'Pendiente':
                    $estadoStyle = 'color: #d97706; font-weight: bold;';
                    break;
                case 'Cancelado':
                    $estadoStyle = 'color: #dc2626; font-weight: bold;';
                    break;
            }

            $html .= '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . sanitize($proyecto['nombre']) . '</td>
                    <td>' . sanitize($proyecto['cliente_nombre']) . '</td>
                    <td>' . formatDate($proyecto['fecha_inicio']) . '</td>
                    <td>' . formatDate($proyecto['fecha_fin']) . '</td>
                    <td style="' . $estadoStyle . '">' . sanitize($proyecto['estado']) . '</td>
                    <td style="text-align:right">' . formatMoney($proyecto['presupuesto']) . '</td>
                </tr>';
            $i++;
        }

        $html .= '
            </tbody>
        </table>
        <div class="footer">
            <p>Total de proyectos: <strong>' . count($proyectos) . '</strong></p>
            <p>Presupuesto total: <strong>' . formatMoney($totalPresupuesto) . '</strong></p>
        </div>';
        $html .= $this->getReportFooter();

        // Generar PDF
        $this->generatePdf($html, 'Reporte_Proyectos_' . date('Y-m-d'));
    }

    /**
     * Generar el encabezado HTML del reporte
     */
    private function getReportHeader($titulo, $fecha)
    {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <style>
                body {
                    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                    font-size: 12px;
                    color: #1e293b;
                    margin: 0;
                    padding: 30px;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                    padding-bottom: 20px;
                    border-bottom: 3px solid #4f46e5;
                }
                .header h1 {
                    font-size: 24px;
                    color: #4f46e5;
                    margin: 0 0 5px 0;
                }
                .header .subtitle {
                    font-size: 13px;
                    color: #64748b;
                }
                .header .date {
                    font-size: 11px;
                    color: #94a3b8;
                    margin-top: 8px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                table th {
                    background-color: #4f46e5;
                    color: white;
                    padding: 10px 8px;
                    text-align: left;
                    font-size: 11px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                table td {
                    padding: 9px 8px;
                    border-bottom: 1px solid #e2e8f0;
                    font-size: 11px;
                }
                table tbody tr:nth-child(even) {
                    background-color: #f8fafc;
                }
                table tbody tr:hover {
                    background-color: #eef2ff;
                }
                .footer {
                    margin-top: 20px;
                    padding-top: 15px;
                    border-top: 2px solid #e2e8f0;
                    font-size: 12px;
                    color: #475569;
                }
                .footer p {
                    margin: 4px 0;
                }
                .page-footer {
                    position: fixed;
                    bottom: 20px;
                    left: 30px;
                    right: 30px;
                    text-align: center;
                    font-size: 10px;
                    color: #94a3b8;
                    border-top: 1px solid #e2e8f0;
                    padding-top: 10px;
                }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>' . $titulo . '</h1>
                <div class="subtitle">Sistema de Gestión - Caso Práctico Backend</div>
                <div class="date">Generado el: ' . $fecha . '</div>
            </div>';
    }

    /**
     * Generar el pie de página HTML del reporte
     */
    private function getReportFooter()
    {
        return '
            <div class="page-footer">
                Caso Práctico Backend Developer Web &mdash; SENATI ' . date('Y') . '
            </div>
        </body>
        </html>';
    }

    /**
     * Generar y descargar el PDF usando Dompdf
     */
    private function generatePdf($html, $filename)
    {
        // Verificar que Dompdf está disponible
        if (!class_exists('Dompdf\Dompdf')) {
            setFlash('danger', 'Error: Dompdf no está instalado. Ejecuta "composer install" en la raíz del proyecto.');
            redirect('index.php?controller=reportes&action=index');
            return;
        }

        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Guardar una copia en la carpeta reports/
        $reportsDir = ROOT_PATH . '/reports/';
        if (!is_dir($reportsDir)) {
            mkdir($reportsDir, 0755, true);
        }
        file_put_contents($reportsDir . $filename . '.pdf', $dompdf->output());

        // Enviar PDF al navegador para descarga
        $dompdf->stream($filename . '.pdf', ['Attachment' => true]);
        exit;
    }
}
