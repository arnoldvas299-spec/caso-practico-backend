# Caso Práctico - Backend Developer Web

## 📋 Descripción

Sistema web completo desarrollado en **PHP**, **MySQL** y **PDO** con arquitectura **MVC** (Modelo-Vista-Controlador). Incluye gestión de clientes, proyectos, generación de reportes PDF y un sistema de autenticación seguro.

**Desarrollado para:** SENATI - Caso Práctico Backend Developer Web

---

## 🚀 Tecnologías Utilizadas

| Tecnología  | Uso                              |
|-------------|----------------------------------|
| PHP 8.x     | Lenguaje de programación backend |
| MySQL 8.x   | Base de datos relacional         |
| PDO         | Conexión segura a base de datos  |
| Dompdf      | Generación de reportes PDF       |
| HTML5 / CSS | Interfaz de usuario              |
| Composer    | Gestión de dependencias PHP      |
| XAMPP       | Servidor local de desarrollo     |

---

## 📁 Estructura del Proyecto

```
caso-practico-backend/
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── ClienteController.php
│   │   ├── DashboardController.php
│   │   ├── ProyectoController.php
│   │   └── ReporteController.php
│   ├── models/
│   │   ├── Usuario.php
│   │   ├── Cliente.php
│   │   └── Proyecto.php
│   ├── views/
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── clientes/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   ├── proyectos/
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   ├── reportes/
│   │   │   └── index.php
│   │   ├── layouts/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   └── dashboard.php
│   └── helpers.php
├── config/
│   └── database.php
├── public/
│   ├── index.php
│   └── assets/
│       └── css/
│           └── style.css
├── reports/
├── vendor/ (generado por Composer)
├── composer.json
├── database.sql
└── README.md
```

---

## ⚙️ Instalación Paso a Paso

### Requisitos Previos

- **XAMPP** instalado (incluye Apache, MySQL y PHP)
- **Composer** instalado ([descargar aquí](https://getcomposer.org/download/))

### Paso 1: Clonar o Copiar el Proyecto

Copiar la carpeta del proyecto en la ruta de XAMPP:

```
C:\xampp\htdocs\caso-practico-backend
```

### Paso 2: Crear la Base de Datos

1. Abre **XAMPP Control Panel** y enciende **Apache** y **MySQL**.
2. Abre **phpMyAdmin** en el navegador: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
3. Haz clic en la pestaña **"SQL"** (en la parte superior).
4. Abre el archivo `database.sql` con un editor de texto, copia todo su contenido y pégalo en phpMyAdmin.
5. Haz clic en **"Continuar"** o **"Go"** para ejecutar las consultas.

> **Nota:** También puedes importar el archivo directamente:
> - En phpMyAdmin, ve a la pestaña **"Importar"**
> - Selecciona el archivo `database.sql`
> - Haz clic en **"Continuar"**

### Paso 3: Configurar la Conexión a la Base de Datos

Abre el archivo `config/database.php` y verifica la configuración:

```php
private static $host = 'localhost';
private static $dbname = 'caso_practico_backend';
private static $username = 'root';       // Usuario por defecto de XAMPP
private static $password = '';            // Contraseña por defecto de XAMPP (vacía)
```

> Si tu MySQL tiene una contraseña diferente, cámbiala en el archivo.

### Paso 4: Instalar Dependencias (Dompdf)

Abre una terminal (CMD o PowerShell) y navega a la carpeta del proyecto:

```bash
cd C:\xampp\htdocs\caso-practico-backend
composer install
```

> Esto instalará la librería **Dompdf** necesaria para generar reportes PDF.

### Paso 5: Acceder al Sistema

Abre tu navegador y visita:

```
http://localhost/caso-practico-backend/public/
```

---

## 🔐 Primer Uso

1. Al acceder por primera vez, verás la página de **Login**.
2. Haz clic en **"Regístrate aquí"** para crear tu cuenta.
3. Completa el formulario de registro con tu nombre, email y contraseña.
4. Inicia sesión con tus credenciales.
5. ¡Listo! Estarás en el **Dashboard** principal.

---

## 📌 Funcionalidades

### ✅ Autenticación
- Registro de usuarios
- Login con validación
- Sesiones PHP seguras
- Contraseñas cifradas con `password_hash()` y verificadas con `password_verify()`
- Protección de rutas (middleware)
- Botón de cerrar sesión

### ✅ Gestión de Clientes (CRUD)
- Registrar nuevo cliente
- Listar todos los clientes
- Editar datos de un cliente
- Eliminar cliente (con confirmación)

### ✅ Gestión de Proyectos (CRUD)
- Registrar nuevo proyecto vinculado a un cliente
- Listar todos los proyectos con estado y presupuesto
- Editar datos de un proyecto
- Eliminar proyecto (con confirmación)

### ✅ Reportes PDF
- Reporte de clientes en PDF
- Reporte de proyectos en PDF
- Cada reporte incluye: título, tabla de datos, fecha de generación
- Los reportes se descargan automáticamente y se guardan en `/reports/`

### ✅ Dashboard
- Estadísticas generales (clientes, proyectos, en progreso, completados)
- Tabla de últimos proyectos
- Accesos rápidos a las secciones principales

---

## 🛡️ Seguridad

- **PDO** con consultas preparadas (prevención de inyección SQL)
- **password_hash()** para cifrado de contraseñas
- **password_verify()** para verificación segura
- **htmlspecialchars()** para prevención de XSS
- **Sesiones PHP** para autenticación
- **Middleware** para proteger rutas internas

---

## 📊 Datos de Prueba

El archivo `database.sql` incluye datos de prueba:
- **7 clientes** de ejemplo con datos completos
- **8 proyectos** de ejemplo con diferentes estados y presupuestos

---

## 🎨 Diseño

- Interfaz moderna y responsive
- Sidebar con navegación intuitiva
- Diseño adaptable para laptop y celular
- Tipografía profesional (Google Fonts - Inter)
- Animaciones suaves y transiciones
- Badges de colores para estados de proyectos

---

## 👤 Autor

Proyecto desarrollado como caso práctico para **SENATI**  
Programa: **Backend Developer Web**

---

## 📝 Licencia

Este proyecto es de uso educativo para SENATI.
