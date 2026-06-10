<?php
/**
 * Script de inicialización de base de datos
 * 
 * Ejecutar UNA SOLA VEZ después del primer deploy para crear las tablas.
 * 
 * Uso desde terminal (en Render Shell o localmente):
 *   php init-db.php
 * 
 * O accediendo desde el navegador:
 *   https://tu-app.onrender.com/init-db.php
 *   (luego elimina este archivo del servidor por seguridad)
 */

// Leer variables de entorno
$host     = getenv('DB_HOST') ?: 'localhost';
$dbname   = getenv('DB_NAME') ?: 'caso_practico_backend';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '';

echo "=== Inicialización de Base de Datos ===\n\n";
echo "Host: $host\n";
echo "Database: $dbname\n";
echo "User: $username\n\n";

try {
    // Conectar a la base de datos
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    echo "✅ Conexión exitosa a la base de datos.\n\n";

    // Leer el archivo SQL (omitimos CREATE DATABASE y USE, ya que la BD ya existe en servicios externos)
    $sqlFile = __DIR__ . '/database.sql';

    if (!file_exists($sqlFile)) {
        die("❌ Error: No se encontró el archivo database.sql\n");
    }

    $sql = file_get_contents($sqlFile);

    // Eliminar las líneas CREATE DATABASE y USE (ya que en servicios externos la BD viene creada)
    $sql = preg_replace('/CREATE DATABASE.*?;/is', '', $sql);
    $sql = preg_replace('/USE\s+\w+\s*;/i', '', $sql);

    // Ejecutar las sentencias SQL
    $pdo->exec($sql);

    echo "✅ Tablas creadas exitosamente.\n";
    echo "✅ Datos de prueba insertados.\n\n";
    echo "=== ¡Base de datos inicializada correctamente! ===\n\n";
    echo "⚠️  IMPORTANTE: Elimina este archivo (init-db.php) del servidor después de usarlo.\n";

} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "\n";
    exit(1);
}
