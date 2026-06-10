<!-- Página de Reportes -->
<div class="slide-in">
    <div class="mb-3">
        <p style="color: var(--text-muted); font-size: 15px;">
            Genera reportes en formato PDF de los datos del sistema. Los archivos se descargarán automáticamente
            y también se guardarán en la carpeta <code>reports/</code> del proyecto.
        </p>
    </div>

    <div class="reports-grid">
        <!-- Reporte de Clientes -->
        <div class="report-card">
            <div class="report-icon blue">👥</div>
            <h3>Reporte de Clientes</h3>
            <p>
                Genera un documento PDF con el listado completo de todos los clientes
                registrados en el sistema, incluyendo sus datos de contacto.
            </p>
            <a href="<?php echo url('reportes', 'clientes'); ?>" class="btn btn-primary" id="btnReporteClientes">
                📄 Descargar PDF
            </a>
        </div>

        <!-- Reporte de Proyectos -->
        <div class="report-card">
            <div class="report-icon green">📁</div>
            <h3>Reporte de Proyectos</h3>
            <p>
                Genera un documento PDF con el listado completo de todos los proyectos,
                incluyendo el cliente asociado, estado, fechas y presupuesto.
            </p>
            <a href="<?php echo url('reportes', 'proyectos'); ?>" class="btn btn-success" id="btnReporteProyectos">
                📄 Descargar PDF
            </a>
        </div>
    </div>

    <!-- Info adicional -->
    <div class="card mt-3">
        <div class="card-body">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">ℹ️ Información sobre los Reportes</h3>
            <ul style="color: var(--text-secondary); font-size: 14px; line-height: 2; padding-left: 20px;">
                <li>Los reportes se generan en formato <strong>PDF</strong> utilizando la librería <strong>Dompdf</strong>.</li>
                <li>Cada reporte incluye <strong>título</strong>, <strong>tabla de datos</strong> y <strong>fecha de generación</strong>.</li>
                <li>Los archivos PDF se descargan automáticamente al navegador.</li>
                <li>Una copia del reporte se guarda en la carpeta <code>reports/</code> del proyecto.</li>
                <li>Los reportes se generan en formato <strong>A4 horizontal</strong> (landscape).</li>
            </ul>
        </div>
    </div>
</div>
