-- =====================================================
-- Base de datos: caso_practico_backend
-- Caso Práctico - Backend Developer Web
-- Autor: SENATI
-- =====================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS caso_practico_backend
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE caso_practico_backend;

-- =====================================================
-- Tabla: usuarios
-- Almacena los usuarios del sistema (login/registro)
-- =====================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabla: clientes
-- Almacena la información de los clientes
-- =====================================================
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefono VARCHAR(20) DEFAULT NULL,
    empresa VARCHAR(150) DEFAULT NULL,
    direccion VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Tabla: proyectos
-- Almacena los proyectos, cada uno vinculado a un cliente
-- =====================================================
CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT DEFAULT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE DEFAULT NULL,
    estado ENUM('Pendiente', 'En Progreso', 'Completado', 'Cancelado') DEFAULT 'Pendiente',
    presupuesto DECIMAL(12,2) DEFAULT 0.00,
    cliente_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Datos de prueba: Clientes
-- =====================================================
INSERT INTO clientes (nombre, email, telefono, empresa, direccion) VALUES
('Carlos Mendoza', 'carlos.mendoza@email.com', '987654321', 'Tech Solutions SAC', 'Av. Javier Prado 1234, Lima'),
('María García', 'maria.garcia@email.com', '912345678', 'Innovación Digital EIRL', 'Jr. Huallaga 456, Lima'),
('Juan Pérez', 'juan.perez@email.com', '956789012', 'Constructora Pérez SA', 'Av. Arequipa 789, Lima'),
('Ana Torres', 'ana.torres@email.com', '934567890', 'Diseño Creativo SRL', 'Calle Los Olivos 321, Trujillo'),
('Roberto Silva', 'roberto.silva@email.com', '978901234', 'Logística Express SAC', 'Av. Colonial 567, Callao'),
('Lucía Ramírez', 'lucia.ramirez@email.com', '945678901', 'Consultoría Empresarial SAC', 'Jr. Camaná 890, Lima'),
('Diego Vargas', 'diego.vargas@email.com', '923456789', 'Alimentos del Norte SA', 'Av. Larco 1122, Trujillo');

-- =====================================================
-- Datos de prueba: Proyectos
-- =====================================================
INSERT INTO proyectos (nombre, descripcion, fecha_inicio, fecha_fin, estado, presupuesto, cliente_id) VALUES
('Sistema de Inventarios', 'Desarrollo de un sistema web para gestión de inventarios con código de barras y reportes.', '2026-01-15', '2026-06-30', 'En Progreso', 15000.00, 1),
('Página Web Corporativa', 'Diseño y desarrollo de página web institucional con blog integrado y formulario de contacto.', '2026-02-01', '2026-04-15', 'Completado', 5500.00, 2),
('App de Control de Obras', 'Aplicación móvil para seguimiento de avance de obras con fotografías y reportes de progreso.', '2026-03-10', '2026-09-30', 'En Progreso', 25000.00, 3),
('Rediseño de Marca', 'Rediseño completo de identidad visual: logotipo, manual de marca y papelería corporativa.', '2026-04-01', '2026-05-15', 'Completado', 3500.00, 4),
('Sistema de Rastreo GPS', 'Plataforma web de rastreo de unidades vehiculares en tiempo real con alertas y geofencing.', '2026-05-01', '2026-12-31', 'Pendiente', 35000.00, 5),
('Portal de Capacitación', 'Plataforma e-learning con módulos, evaluaciones, certificados y panel administrativo.', '2026-03-20', '2026-08-20', 'En Progreso', 18000.00, 6),
('E-commerce de Productos', 'Tienda virtual con carrito de compras, pasarela de pagos y gestión de pedidos.', '2026-06-01', '2026-11-30', 'Pendiente', 22000.00, 7),
('Dashboard Analítico', 'Panel de control con indicadores KPI, gráficos interactivos y exportación de datos.', '2026-01-10', '2026-03-30', 'Completado', 8000.00, 1);
